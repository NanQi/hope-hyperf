<?php

declare(strict_types=1);


namespace NanQi\Hope\Exception;

use NanQi\Hope\Base\BaseException;

/**
 * Class BusinessException
 * @var int $statusCode
 * @var string $errorMessage
 * @var int $errorCode
 * @package App\Exception
 */
class BusinessException extends BaseException
{
    /**
     * @var int
     */
    public $statusCode;
    /**
     * @var string
     */
    public $errorMessage;
    /**
     * @var int
     */
    public $errorCode;

    public function __construct(int $statusCode, string $errorMessage, int $errorCode = 0)
    {
        parent::__construct($errorMessage);

        $this->statusCode = $statusCode;
        $this->errorMessage = $errorMessage;
        $this->errorCode = $errorCode;
    }
}
