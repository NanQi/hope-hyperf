<?php

namespace NanQi\Hope;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\Handler\WhoopsExceptionHandler;
use Hyperf\ExceptionHandler\Listener\ErrorExceptionHandler;
use Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler;
use Hyperf\Server\CoroutineServer;
use Hyperf\Validation\Middleware\ValidationMiddleware;
use NanQi\Hope\Aspect\ResponseAspect;
use NanQi\Hope\Exception\Handler\AppExceptionHandler;
use NanQi\Hope\Exception\Handler\BusinessExceptionHandler;
use NanQi\Hope\Exception\Handler\NotFoundExceptionHandler;
use NanQi\Hope\Exception\Handler\ValidationExceptionHandler;
use NanQi\Hope\Di\StdoutLogger;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'aspects'=>[
                ResponseAspect::class
            ],
            'dependencies' => [
                StdoutLoggerInterface::class => StdoutLogger::class
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
            'commands' => [],
            'listeners' => [
                ErrorExceptionHandler::class
            ],
            'middlewares' => [
                'http' => [
                    ValidationMiddleware::class
                ],
            ],
            'exceptions' => [
                'handler' => [
                    'http' => [
                        BusinessExceptionHandler::class,
                        NotFoundExceptionHandler::class,
                        HttpExceptionHandler::class,
                        ValidationExceptionHandler::class,
                        WhoopsExceptionHandler::class,
                        AppExceptionHandler::class,
                    ],
                ],
            ]
            // 组件默认配置文件，即执行命令后会把 source 的对应的文件复制为 destination 对应的的文件
//            'publish' => [
//                [
//                    'id' => 'config',
//                    'description' => 'description of this config file.', // 描述
//                    // 建议默认配置放在 publish 文件夹中，文件命名和组件名称相同
//                    'source' => __DIR__ . '/../publish/file.php',  // 对应的配置文件路径
//                    'destination' => BASE_PATH . '/config/autoload/file.php', // 复制为这个路径下的该文件
//                ],
//            ],
            // 亦可继续定义其它配置，最终都会合并到与 ConfigInterface 对应的配置储存器中
        ];
    }
}
