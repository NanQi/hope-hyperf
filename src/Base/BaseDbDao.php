<?php

declare(strict_types=1);

namespace NanQi\Hope\Base;

use Hyperf\Di\Annotation\Inject;
use NanQi\Hope\Helper;
use Psr\EventDispatcher\EventDispatcherInterface;

abstract class BaseDbDao extends BaseDao
{
    use Helper;

}
