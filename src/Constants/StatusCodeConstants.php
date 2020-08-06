<?php

declare(strict_types=1);

namespace NanQi\Hope\Constants;

use NanQi\Hope\Base\BaseConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class StatusCodeConstants extends BaseConstants
{
    /**
     * @Message("服务异常，请稍后尝试")
     */
    const S_500_SERVER_ERROR = 500;

    /**
     * @Message("错误的请求")
     */
    const S_400_BAD_REQUEST = 400;

    /**
     * @Message("未授权，请重新登录")
     */
    const S_401_UNAUTHORIZED = 401;

    /**
     * @Message("没有权限")
     */
    const S_403_FORBIDDEN = 403;

    /**
     * @Message("找不到对象或数据")
     */
    const S_404_NOT_FOUND = 404;
}
