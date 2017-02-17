<?php

namespace Majesko\Logger\Wrappers;

use Monolog\Handler\StreamHandler;

class StreamWrapper extends BaseWrapper
{

    public function getHandler()
    {
        $handler = new StreamHandler($this->params['target'] . $this->params['filename']);

        return $handler;
    }
}
