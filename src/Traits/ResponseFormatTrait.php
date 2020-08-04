<?php

declare(strict_types=1);

namespace NanQi\Hope\Traits;

use NanQi\Hope\Exception\BusinessException;

trait ResponseFormatTrait {

    public function errorFormat(int $statusCode, string $errorMessage, object $data = null, int $errorCode = 0) {
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
     * @param int $statusCode
     * @param string $errorMessage
     * @param int $errorCode
     */
    public function retError(int $statusCode, string $errorMessage, int $errorCode = 0)
    {
        throw new BusinessException($statusCode, $errorMessage, $errorCode);
    }
}