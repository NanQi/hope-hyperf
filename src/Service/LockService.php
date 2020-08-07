<?php
declare(strict_types=1);

namespace NanQi\Hope\Service;

use NanQi\Hope\Base\BaseService;

class LockService extends BaseService {
    //加锁
    public function lock($key,$expire=5){
        $redis = $this->getRedis();
        $is_lock = $redis->setnx($key,time() + $expire);
        if(!$is_lock){
            $lock_time = $redis->get($key);
            //锁已过期，重置
            if($lock_time <time()){
                $this->unlock($key);
                $is_lock=$redis->setnx($key,time()+$expire);
            }
        }
        return $is_lock ? true : false;
    }
    // 释放锁
    public function unlock($key){
        $redis = $this->getRedis();
        return $redis->del($key);
    }
}

