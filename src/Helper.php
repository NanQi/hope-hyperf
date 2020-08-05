<?php


namespace NanQi\Hope;


use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Utils\ApplicationContext;
use NanQi\Hope\Constants\ErrorCodeConstants;
use NanQi\Hope\Constants\StatusCodeConstants;
use NanQi\Hope\Exception\BusinessException;
use NanQi\Hope\Traits\ResponseFormatTrait;
use Psr\Container\ContainerInterface;

trait Helper
{
    /**
     * @Inject(lazy=true)
     * @var ContainerInterface
     */
    private $container;

    /**
     * 获取日志
     * @return StdoutLoggerInterface
     */
    public function getLogger()
    {
        /**
         * @var $logger StdoutLoggerInterface
         */
        $logger = ApplicationContext::getContainer()->get(StdoutLoggerInterface::class);
        return $logger;
    }

    /**
     * 返回错误
     * @param int $errorCode
     * @param string $errorMessage
     */
    public function retError(int $errorCode, string $errorMessage = null)
    {
        /** @var ErrorCodeConstants $errorCodeConstants */
        $errorCodeConstants = ApplicationContext::getContainer()->get(ErrorCodeConstants::class);
        if (!$errorMessage && $errorCodeConstants) {
            $errorMessage = $errorCodeConstants::getMessage($errorCode);
        }

        throw new BusinessException(StatusCodeConstants::S_400_BAD_REQUEST,
            $errorMessage, $errorCode);
    }
}