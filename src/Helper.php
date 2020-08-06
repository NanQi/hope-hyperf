<?php


namespace NanQi\Hope;


use Hyperf\Cache\CacheManager;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Di\Annotation\Inject;
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
     * @return RedisProxy|\Redis
     */
    public function getRedis($name = null) : RedisProxy
    {
        /** @var RedisFactory $redisFactory */
        $redisFactory = di(RedisFactory::class);
        return $redisFactory->get($name);
    }

    /**
     * 获取日志
     * @return StdoutLoggerInterface
     */
    public function getLogger() : StdoutLoggerInterface
    {
        /**
         * @var StdoutLoggerInterface $logger
         */
        $logger = di(StdoutLoggerInterface::class);
        return $logger;
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