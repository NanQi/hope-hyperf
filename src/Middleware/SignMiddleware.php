<?php

declare(strict_types=1);

namespace NanQi\Hope\Middleware;

use Closure;
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


class SignMiddleware implements MiddlewareInterface
{
    use Helper;
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$this->isProduct()) {
            return $handler->handle($request);
        }

        $this->verify_sign(function() {
            $auth_id = $this->getAuthId();
            if ($auth_id) {
                /** @var SignService $signService */
                $signService = di(SignService::class);
                $timestamp = $this->getReq()->input('sign_timestamp');
                return $signService->encode_user_id($auth_id) . $timestamp;
            } else {
                return env('API_SIGN', 'nanqi');
            }
        });

        return $handler->handle($request);
    }


    /**
     * 验证签名
     * @param Closure $funGetSignKey
     */
    protected function verify_sign(Closure $funGetSignKey)
    {
        $params = $this->getReq()->all();
        if (!array_key_exists('sign', $params)
            || !array_key_exists('sign_timestamp', $params)
            || !array_key_exists('sign_guid', $params) ) {
            $this->errorUnauthorized("缺少签名参数");
        }

        $timestamp = $params['sign_timestamp'];
        $now = time();
        if (abs($now - $timestamp) > 60 * 10) {
            $this->errorUnauthorized("签名已过期");
        }

        /** @var SignService $signService */
        $signService = di(SignService::class);

        $sign_key = $funGetSignKey->call($this);
        if ($sign_key === false) {
            $this->errorUnauthorized("获取密钥错误");
        }

        $guid = $params['sign_guid'];
        $redis = $this->getRedis();
        $cacheKey = "sign:" . $guid;
        $isRepeat = $redis->get($cacheKey);
        if ($isRepeat) {
            $this->errorUnauthorized("重放攻击");
        }

        $tmp_data = $params;
        unset($tmp_data['sign']);

        $sign = $signService->get_sign($tmp_data, $sign_key);

        if ($params['sign'] !== $sign) {
            $this->errorUnauthorized("签名错误");
        }

        $redis->set($cacheKey, true, 60);
    }
}
