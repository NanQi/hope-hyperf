<?php

namespace NanQi\Hope\Exception;

use NanQi\Hope\Base\BaseException;

class StaleModelLockingException extends BaseException {
    protected $message = "数据库乐观锁出错";
}
