<?php

declare(strict_types=1);

namespace NanQi\Hope\Middleware;

use NanQi\Hope\Exception\BusinessException;
use NanQi\Hope\Helper;
use NanQi\Hope\Service\JwtService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\Utils\Context;


class TestMiddleware implements MiddlewareInterface
{
    use Helper;
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->isProduct()) {
            $this->errorForbidden();
        }
        return $handler->handle($request);
    }
}
