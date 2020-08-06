<?php

declare(strict_types=1);

namespace NanQi\Hope\Base;

use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;
use NanQi\Hope\Helper;

abstract class BaseRedisDao extends BaseDao
{
    use Helper;
}
