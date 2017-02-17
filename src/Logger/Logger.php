<?php

namespace Majesko\Logger;

use Illuminate\Log\Writer;
use Monolog\Processor\TagProcessor;
use Monolog\Logger as MonologLogger;
use Illuminate\Contracts\Events\Dispatcher;

class Logger extends Writer
{

    private $channels;
    protected $globalChannels;

    /**
     * Create a new log writer instance.
     *
     * @param  \Monolog\Logger $monolog
     * @param  \Illuminate\Contracts\Events\Dispatcher $dispatcher
     * @return void
     */
    public function __construct(MonologLogger $monolog, Dispatcher $dispatcher = null)
    {
        parent::__construct($monolog, $dispatcher);
        $this->flushChannels(); // protection from fools, and possible bugs from laravel bootstrap process

        $this->globalChannels = config('logger.channels.global');

        if (!$this->channels) {
            $this->channels = $this->globalChannels;
        }

        $this->monolog = $monolog;

        $this->attachChannels($this->globalChannels);

        if (isset($dispatcher)) {
            $this->dispatcher = $dispatcher;
        }
    }

    /**
     * Write a message to Monolog.
     *
     * @param  string $level
     * @param  string $message
     * @param  array $context
     * @return void
     */
    protected function writeLog($level, $message, $context)
    {
        $this->fireLogEvent($level, $message = $this->formatMessage($message), $context);

        $this->monolog->pushProcessor(new TagProcessor($this->channels));
        $this->monolog->{$level}($message, $context);
        $this->monolog->popProcessor();

        return $this;
    }

    /**
     * Inserts array of channels into handlers stack
     *
     * @param array $channels
     * @return $this
     */
    public function setChannels($channels = ['default'])
    {
        $this->channels = (array)$channels;
        $this->attachChannels($this->channels);

        return $this;
    }

    /**
     * Attaches handlers into channel stack
     *
     * @param array $channels
     * @return bool
     * @throws \Exception
     */
    public function attachChannels(array $channels)
    {


        foreach ($channels as $channel) {
            if (!in_array($channel, array_keys(config('logger.channels')))) {
                throw new \Exception('Invalid channel: ' . print_r($channel, true));
            }

            $handlerParams = config('logger.channels')[$channel];
            $handler = HandlerFactory::buildHandler($handlerParams);

            $this->monolog->pushHandler($handler);
        }

        return true;
    }

    /**
     * Removes all handlers from active handlers stack
     */
    private function flushChannels()
    {
        foreach ($this->monolog->getHandlers() as $handler) {
            $this->monolog->popHandler();
        }
    }

    /**
     * Restores handler stack to global default
     */
    public function restoreChannels()
    {
        $this->flushChannels();
        $this->channels = $this->globalChannels;
        $this->attachChannels($this->channels);
    }

    /*
     * Disable laravel built-in handlers
     * This will needed because usage of these methods is hardcoded into laravel bootstrap process
     */
    public function useFiles($path, $level = 'debug')
    {
    }

    public function useDailyFiles($path, $days = 0, $level = 'debug')
    {
    }
}
