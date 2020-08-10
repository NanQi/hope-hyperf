<?php

declare(strict_types=1);


namespace NanQi\Hope\Exception\Handler;

use NanQi\Hope\Exception\BusinessException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class BusinessExceptionHandler extends BaseExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();

        /**
         * @var BusinessException $throwable
         */
        return $this->errorResponse($response, $throwable->statusCode, $throwable->errorMessage, null, $throwable->errorCode);
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof BusinessException;
    }
}
