<?php


namespace NanQi\Hope;


use Hyperf\Cache\CacheManager;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Redis\RedisFactory;
use Hyperf\Redis\RedisProxy;
use Hyperf\Utils\ApplicationContext;
use NanQi\Hope\Constants\ErrorCodeConstants;
use NanQi\Hope\Constants\StatusCodeConstants;
use NanQi\Hope\Exception\BusinessException;
use NanQi\Hope\Service\JwtService;
use NanQi\Hope\Traits\ResponseFormatTrait;
use Psr\Container\ContainerInterface;
use Psr\SimpleCache\CacheInterface;

trait Helper
{
    use ResponseFormatTrait;
    /**
     * @Inject(lazy=true)
     * @var ContainerInterface
     */
    private $ioc;

    /**
     * 获取Redis
     * @param $name
     * @return RedisProxy
     */
    public function getRedis($name = 'default') : RedisProxy
    {
        /** @var RedisFactory $redisFactory */
        $redisFactory = di(RedisFactory::class);
        return $redisFactory->get($name);
    }

    /**
     * 获取请求对象
     * @return RequestInterface
     */
    public function getReq() : RequestInterface
    {
        return di(RequestInterface::class);
    }

    /**
     * 获取响应对象
     * @return ResponseInterface
     */
    public function getRes() : ResponseInterface
    {
        return di(ResponseInterface::class);
    }

    /**
     * 是否生产环境
     * @return bool
     */
    public function isProduct() : bool
    {
        $appEnv = env('APP_ENV', 'dev');
        return $appEnv == 'prod';
    }

    /**
     * 获取日志
     * @return StdoutLoggerInterface
     */
    public function getLog() : StdoutLoggerInterface
    {
        return di(StdoutLoggerInterface::class);
    }

    /**
     * 获取授权用户ID
     */
    public function getAuthId() : int
    {
        /** @var JwtService $jwtService */
        $jwtService = di(JwtService::class);
        $user_id = $jwtService->checkToken();
        if ($user_id === false) {
            $this->errorUnauthorized();
        }

        return $user_id;
    }

    /**
     * 是否登录
     * @return bool
     */
    public function isLogin() : bool
    {
        return !!$this->getAuthId();
    }

    /**
     * 获取全局缓存
     */
    public function getArrayCache() : CacheInterface
    {
        /** @var CacheManager $cacheManager */
        $cacheManager = di(CacheManager::class);
        $cache = $cacheManager->getDriver('array');
        return $cache;
    }

    /**
     * 获取缓存对象
     */
    public function getCache() : CacheInterface
    {
        /** @var CacheInterface $cache */
        $cache = di(CacheInterface::class);
        return $cache;
    }
}