<?php

declare(strict_types=1);

namespace NanQi\Hope\Base;

use Hyperf\Di\Annotation\Inject;
use NanQi\Hope\Helper;
use Psr\EventDispatcher\EventDispatcherInterface;

abstract class BaseRedisDao extends BaseDao
{
    use Helper;

}
