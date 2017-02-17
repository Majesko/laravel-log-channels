<?php

namespace Majesko\Logger\Wrappers;

use Monolog\Formatter\FormatterInterface;

abstract class BaseWrapper
{

    protected $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public abstract function getHandler();

    /**
     * @param FormatterInterface $formatter
     * @return $this
     */
    public function setFormatter(FormatterInterface $formatter)
    {
        $this->setFormatter($formatter);

        return $this;
    }
}
