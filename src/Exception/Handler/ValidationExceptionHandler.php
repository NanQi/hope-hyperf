<?php

declare(strict_types=1);

namespace NanQi\Hope\Exception\Handler;

use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ValidationExceptionHandler extends BaseExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();

        /** @var ValidationException $throwable */
        return $this->errorResponse($response,
            $throwable->status,
            $throwable->validator->errors()->first(),
            $throwable->validator->errors());
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ValidationException;
    }
}
