<?php

declare(strict_types=1);

namespace NanQi\Hope\Exception\Handler;

use NanQi\Hope\Constants\StatusCodeConstants;
use NanQi\Hope\Helper;
use NanQi\Hope\Traits\ResponseFormatTrait;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class BaseExceptionHandler extends ExceptionHandler
{
    use Helper;
    /**
     * @var StdoutLoggerInterface
     */
    protected $logger;

    public function __construct(StdoutLoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        return $this->errorResponse($response, StatusCodeConstants::S_500_SERVER_ERROR, StatusCodeConstants::getMessage(StatusCodeConstants::S_500_SERVER_ERROR));
    }

    protected function errorResponse(ResponseInterface $response,
                                     int $statusCode,
                                     string $errorMessage,
                                     $data = null,
                                     int $errorCode = 0)
    {
        return $response
            ->withStatus($statusCode)
            ->withHeader('Content-type', 'application/json')
            ->withBody(new SwooleStream(
                $this->errorFormat($statusCode, $errorMessage, $data, $errorCode)));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
