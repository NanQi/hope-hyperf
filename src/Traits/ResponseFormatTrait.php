<?php

declare(strict_types=1);

namespace NanQi\Hope\Traits;

use Hyperf\Utils\ApplicationContext;
use NanQi\Hope\Constants\ErrorCodeConstants;
use NanQi\Hope\Constants\StatusCodeConstants;
use NanQi\Hope\Exception\BusinessException;
use NanQi\Hope\Helper;

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

    public function errorStatusCode(int $statusCode)
    {
        throw new BusinessException($statusCode,
            StatusCodeConstants::getMessage($statusCode),
            $statusCode);
    }

    /**
     * Return a 404 not found error.
     * @return void
     */
    public function errorNotFound()
    {
        $this->errorStatusCode(StatusCodeConstants::S_404_NOT_FOUND);
    }

    /**
     * Return a 403 forbidden error.
     * @return void
     */
    public function errorForbidden()
    {
        $this->errorStatusCode(StatusCodeConstants::S_403_FORBIDDEN);
    }

    /**
     * Return a 401 unauthorized error.
     * @return void
     */
    public function errorUnauthorized()
    {
        $this->errorStatusCode(StatusCodeConstants::S_401_UNAUTHORIZED);
    }
}