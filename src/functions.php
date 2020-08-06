<?php

use Hyperf\Utils\ApplicationContext;

if (!function_exists('di')) {
    /**
     * 获取依赖注入对象
     * @param string $id
     * @return mixed Entry.
     */
    function di(string $id) {
        return ApplicationContext::getContainer()->get($id);
    }
}
