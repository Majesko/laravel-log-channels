<?php

namespace Majesko\Logger\Wrappers;

use Illuminate\Support\Facades\Redis;
use Monolog\Handler\RedisHandler;

class RedisWrapper extends BaseWrapper {

	public function getHandler() {
		$redis = Redis::connection();
		$redisHandler = new RedisHandler($redis, config('logger.app_name'));

		return $redisHandler;
	}
}
