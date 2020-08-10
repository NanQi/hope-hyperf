<?php
declare(strict_types=1);

namespace NanQi\Hope\Service;

use NanQi\Hope\Base\BaseService;

class LockService extends BaseService {
    const LOCK_PREFIX = 'lock:';
    //加锁
    public function lock($key,$expire=5){
        $redis = $this->getRedis();
        $cacheKey = self::LOCK_PREFIX . $key;
        $is_lock = $redis->setnx($cacheKey, time() + $expire);
        if(!$is_lock){
            $lock_time = $redis->get($cacheKey);
            //锁已过期，重置
            if($lock_time <time()){
                $this->unlock($cacheKey);
                $is_lock=$redis->setnx($cacheKey, time()+$expire);
            }
        }
        return $is_lock ? true : false;
    }
    // 释放锁
    public function unlock($key){
        $redis = $this->getRedis();
        $cacheKey = self::LOCK_PREFIX . $key;
        return $redis->del($cacheKey);
    }
}

