<?php

declare(strict_types=1);

namespace NanQi\Hope\Base;

use NanQi\Hope\Helper;
use Hyperf\Constants\AbstractConstants;

/**
 * Class BaseConstants
 * @package NanQi\Hope\Base
 * @method static getMessage($code)
 */
abstract class BaseConstants extends AbstractConstants
{
    use Helper;
}
