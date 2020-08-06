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


class AuthMiddleware implements MiddlewareInterface
{
    use Helper;
    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    /**
     * @Inject()
     * @var JwtService
     */
    private $jwtService;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $check_result = $this->jwtService->checkToken();
        if (!$check_result){
            $this->errorUnauthorized();
        }
        $request = $request->withAttribute('uid', $check_result);
        Context::set(ServerRequestInterface::class, $request);
        return $handler->handle($request);
    }
}
