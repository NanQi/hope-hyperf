<?php

declare(strict_types=1);

namespace NanQi\Hope\Middleware;

use NanQi\Hope\Exception\BusinessException;
use NanQi\Hope\Helper;
use NanQi\Hope\Service\JwtService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use NanQi\Hope\Service\SignService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\Utils\Context;


class OpenMiddleware extends SignMiddleware
{
    use Helper;
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$this->isProduct()) {
            return $handler->handle($request);
        }

        $app_id = $this->getReq()->input('sign_app_id');
        if (!$app_id) {
            $this->errorUnauthorized('缺少appid');
        }

        $this->verify_sign(function() use ($app_id) {
            $sign_key = $this->getRedisBusiness()->hGet('open_list', $app_id);
            if ($sign_key) {
                return $sign_key;
            } else {
                return false;
            }
        });
        return $handler->handle($request);
    }
}
