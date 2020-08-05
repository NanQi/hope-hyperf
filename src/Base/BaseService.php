<?php

declare(strict_types=1);

namespace NanQi\Hope\Base;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use NanQi\Hope\Helper;
use Psr\EventDispatcher\EventDispatcherInterface;

abstract class BaseService
{
    use Helper;

    /**
     * @Inject
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;
}
