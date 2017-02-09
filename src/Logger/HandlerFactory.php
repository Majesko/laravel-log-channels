<?php

namespace Majesko\Logger;

use Majesko\Logger\Wrappers\BaseWrapper;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\HandlerInterface;

class HandlerFactory {

	public static function buildHandler($params) {

		/** @var BaseWrapper $factory */
		$factory = new $params['handler']($params);

		if(!$factory instanceof BaseWrapper) {
			throw new \Exception('Invalid handler wrapper, check your configuration');
		}

		/** @var HandlerInterface $handler */
		$handler = $factory->getHandler();

		if(isset($params['formatter'])) {
			self::applyFormatter($handler, $params['formatter']);
		}

		return $handler;
	}

	private static function applyFormatter(HandlerInterface $handler, FormatterInterface $formatter) {
		$handler->setFormatter($formatter);
	}
}
