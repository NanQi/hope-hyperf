<?php

declare(strict_types=1);

namespace NanQi\Hope\Exception\Handler;

use App\Exception\BaseException;
use NanQi\Hope\Constants\StatusCodeConstants;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class AppExceptionHandler extends BaseExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        //不输出日志
        if ($throwable instanceof BaseException
        || $throwable instanceof ValidationException) {
        } else {
            $this->logger->error(sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));
            $this->logger->error($throwable->getTraceAsString());
        }

        return $this->errorResponse($response, StatusCodeConstants::S_500_SERVER_ERROR, $throwable->getMessage());
    }
}