<?php

declare(strict_types=1);

namespace NanQi\Hope\Traits;

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
}