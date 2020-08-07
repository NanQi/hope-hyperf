<?php

namespace NanQi\Hope\Service;

use NanQi\Hope\Base\BaseService;

class SignService extends BaseService
{
    /**
     * 获取签名
     * @param $params
     * @param $sign_key
     * @return string
     */
    public function get_sign($params, $sign_key)
    {
        //按字典序排序参数
        ksort($params);
        //$code = http_build_query($params);
        $array = [];
        foreach ($params as $key => $val){
            $val = is_array($val) ? json_encode($val) : $val;
            $array[] = $key . '=' . $val;
        }
        $code = implode('&',$array);
        //拼接密钥
        $code .= '&sign_key=' . $sign_key . 'jieao';

        //MD5加密
        $code = md5($code);
        //所有字符转为大写
        $result = strtoupper($code);
        return $result;
    }

    /**
     * 加密用户ID
     * @param int $user_id
     * @return string
     */
    public function encode_user_id(int $user_id) : string
    {
        return md5($user_id);
    }

    /**
     * 解密签名密钥
     * @param $sign_key
     * @return string
     */
    public function decode_sign_key(string $sign_key) : string
    {
        return $sign_key;
    }
}
