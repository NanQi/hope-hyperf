<?php

declare(strict_types=1);

namespace NanQi\Hope\Base;

use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\RedisProxy;
use NanQi\Hope\Helper;
use NanQi\Hope\Hope;
use Psr\EventDispatcher\EventDispatcherInterface;
use Redis;

abstract class BaseRedisDao extends BaseDao
{
    use Helper;

    /**
     * @var Redis|RedisProxy
     */
    protected $redis;

    public function __construct()
    {
        $this->redis = Hope::getRedis();
    }
}
