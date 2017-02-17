<?php

namespace Majesko\Logger\Wrappers;

use Monolog\Handler\RotatingFileHandler;

class RotatingFileWrapper extends BaseWrapper
{

    public function getHandler()
    {
        $handler = new RotatingFileHandler($this->params['target'] . $this->params['filename'], $this->params['log_max_files']);

        return $handler;
    }
}
