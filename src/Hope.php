<?php
declare(strict_types=1);

namespace NanQi\Hope;

use Hyperf\Contract\StdoutLoggerInterface;
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
        $redis = ApplicationContext::getContainer()
            ->get(RedisFactory::class)
            ->get($name);
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

    /**
     * 获取日志
     * @return StdoutLoggerInterface
     */
    public static function getLogger()
    {
        /**
         * @var $logger StdoutLoggerInterface
         */
        $logger = ApplicationContext::getContainer()->get(StdoutLoggerInterface::class);
        return $logger;
    }
}


