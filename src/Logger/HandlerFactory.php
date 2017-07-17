<?php

namespace Majesko\Logger;

use Majesko\Logger\Wrappers\BaseWrapper;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\HandlerInterface;

class HandlerFactory
{

    public static function buildHandler($handler, $params)
    {
        /** @var BaseWrapper $factory */
        $factory = new $handler($params);

        if (!$factory instanceof BaseWrapper) {
            throw new \Exception('Invalid handler wrapper, check your configuration');
        }

        /** @var HandlerInterface $handler */
        $handler = $factory->getHandler();

        if (isset($params['formatter'])) {
            $class = $params['formatter']['class'];
            $args = $params['formatter']['args'];
            $formatter = new $class(...$args);

            self::applyFormatter($handler, $formatter);
        }

        return $handler;
    }

    private static function applyFormatter(HandlerInterface $handler, FormatterInterface $formatter)
    {
        $handler->setFormatter($formatter);
    }
}
