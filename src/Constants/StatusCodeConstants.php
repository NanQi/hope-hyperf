<?php

declare(strict_types=1);

namespace NanQi\Hope\Constants;

use NanQi\Hope\Base\BaseConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 * @method static getMessage(int $errCode)
 */
class StatusCodeConstants extends BaseConstants
{
    /**
     * @Message("服务异常，请稍后尝试")
     */
    const SERVER_ERROR = 500;

    /**
     * @Message("未授权，请重新登录")
     */
    const UNAUTHORIZED = 401;
}
