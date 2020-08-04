<?php

namespace NanQi\Hope;

use Hyperf\Redis\RedisFactory;
use Hyperf\Redis\RedisProxy;
use Hyperf\Utils\ApplicationContext;

class Hope
{
    /**
     * 获取Redis
     * @param $name
     * @return RedisProxy|\Redis
     */
    public static function getRedis($name = null)
    {
        $container = ApplicationContext::getContainer();
        $redis = $container->get(RedisFactory::class)->get($name);
        return $redis;
    }

    /**
     * 是否生产环境
     * @return bool
     */
    public static function isProduct()
    {
        $appEnv = env('APP_ENV', 'dev');
        return $appEnv == 'prod';
    }
}
