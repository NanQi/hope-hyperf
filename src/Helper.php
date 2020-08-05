<?php


namespace NanQi\Hope;


use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Utils\ApplicationContext;
use NanQi\Hope\Traits\ResponseFormatTrait;

trait Helper
{
    /**
     * 获取日志
     * @return StdoutLoggerInterface
     */
    public static function getLogger()
    {
        /**
         * @var $logger StdoutLoggerInterface
         */
        $logger = ApplicationContext::getContainer()->get(StdoutLoggerInterface::class);
        return $logger;
    }
}