<?php

declare(strict_types=1);

namespace NanQi\Hope\Traits;

use NanQi\Hope\Constants\ErrorCodeConstants;
use NanQi\Hope\Constants\StatusCodeConstants;
use NanQi\Hope\Exception\BusinessException;

trait ResponseFormatTrait {

    public function errorFormat(int $statusCode,
                                string $errorMessage,
                                $data = null,
                                int $errorCode = 0) {
        if ($errorCode === 0) {
            $errorCode = $statusCode;
        }

        $ret = [
            'code' => $errorCode,
            'msg' => $errorMessage
        ];

        if ($data) {
            $ret['data'] = $data;
        }

        return json_encode($ret);
    }

    /**
     * 返回错误
     * @param int $errorCode
     * @param string $errorMessage
     */
    public function retError(int $errorCode, string $errorMessage = null)
    {
        /** @var ErrorCodeConstants $errorCodeConstants */
        $errorCodeConstants = di(ErrorCodeConstants::class);
        if (!$errorMessage && $errorCodeConstants) {
            $errorMessage = $errorCodeConstants::getMessage($errorCode);
        }

        throw new BusinessException(StatusCodeConstants::S_400_BAD_REQUEST,
            $errorMessage, $errorCode);
    }

    public function errorStatusCode(int $statusCode, string $message = null)
    {
        if (!$message) {
            $message = StatusCodeConstants::getMessage($statusCode);
        }

        throw new BusinessException($statusCode,
            $message,
            $statusCode);
    }

    /**
     * Return a 404 not found error.
     * @param string|null $message
     * @return void
     */
    public function errorNotFound(string $message = null)
    {
        $this->errorStatusCode(StatusCodeConstants::S_404_NOT_FOUND, $message);
    }

    /**
     * Return a 403 forbidden error.
     * @param string|null $message
     * @return void
     */
    public function errorForbidden(string $message = null)
    {
        $this->errorStatusCode(StatusCodeConstants::S_403_FORBIDDEN, $message);
    }

    /**
     * Return a 401 unauthorized error.
     * @param string $message
     * @return void
     */
    public function errorUnauthorized(string $message = null)
    {
        $this->errorStatusCode(StatusCodeConstants::S_401_UNAUTHORIZED, $message);
    }
}