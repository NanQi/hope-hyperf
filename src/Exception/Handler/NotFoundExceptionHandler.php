<?php

declare(strict_types=1);

namespace NanQi\Hope\Exception\Handler;

use Hyperf\Database\Model\ModelNotFoundException;
use Hyperf\Validation\ValidationException;
use NanQi\Hope\Constants\StatusCodeConstants;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class NotFoundExceptionHandler extends BaseExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();

        /** @var ModelNotFoundException $throwable */
        return $this->errorResponse($response,
            StatusCodeConstants::S_404_NOT_FOUND,
            "没有找到对应的模型对象",
            [
                'model' => $throwable->getModel(),
                'ids' => implode(',', $throwable->getIds()),
                'trace' => $throwable->getTrace()
            ]);
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ModelNotFoundException;
    }
}
