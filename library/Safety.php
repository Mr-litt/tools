<?php

/**
 * 安全相关
 * Class Safety
 */
class Safety
{
    const DATA_AUTH_KEY = "AFSE";
    /**
     * 系统加密方法
     * @param string $data 要加密的字符串
     * @param string $key  加密密钥
     * @param int $expire  过期时间 单位 秒
     * @return string
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public static function think_encrypt($data, $key = '', $expire = 0) {
        $key  = md5(empty($key) ? self::DATA_AUTH_KEY : $key);
        $data = base64_encode($data);
        $x    = 0;
        $len  = strlen($data);
        $l    = strlen($key);
        $char = '';

        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) $x = 0;
            $char .= substr($key, $x, 1);
            $x++;
        }

        $str = sprintf('%010d', $expire ? $expire + time():0);

        for ($i = 0; $i < $len; $i++) {
            $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1)))%256);
        }
        return str_replace(array('+','/','='),array('-','_',''),base64_encode($str));
    }



    /**
     * 系统解密方法
     * @param  string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
     * @param  string $key  加密密钥
     * @return string
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public static function think_decrypt($data, $key = ''){
        $key    = md5(empty($key) ? self::DATA_AUTH_KEY : $key);
        $data   = str_replace(array('-','_'),array('+','/'),$data);
        $mod4   = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        $data   = base64_decode($data);
        $expire = substr($data,0,10);
        $data   = substr($data,10);

        if($expire > 0 && $expire < time()) {
            return '';
        }
        $x      = 0;
        $len    = strlen($data);
        $l      = strlen($key);
        $char   = $str = '';

        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) $x = 0;
            $char .= substr($key, $x, 1);
            $x++;
        }

        for ($i = 0; $i < $len; $i++) {
            if (ord(substr($data, $i, 1))<ord(substr($char, $i, 1))) {
                $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
            }else{
                $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
            }
        }
        return base64_decode($str);
    }

    /**
     * 密码加密方式
     * @param string $pwd 密码
     * @param string $salt 附加字符
     * @return string
     */
    public static function md5Pwd($pwd, $salt) {
        return md5(md5($pwd).$salt);
    }

    /**
     * 获取输入参数 支持过滤和默认值
     * @param string $name 变量的名称
     * @param mixed $default 不存在的时候默认值
     * @param mixed $filter 参数过滤方法
     * @return mixed
     */
    public static function I($name, $default='', $filter = null) {

        if($name) { // 取值操作
            $filters    =   isset($filter) ? $filter : 'htmlspecialchars';
            if($filters) {
                $filters    =   explode(',',$filters);
                foreach($filters as $filter){
                    if(function_exists($filter)) {
                        $name   =   is_array($name) ? self::array_map_recursive($filter,$name) : $filter($name); // 参数过滤
                    }else{
                        $name   =   filter_var($name,is_int($filter) ? $filter : filter_id($filter));
                        if(false === $name) {
                            return   isset($default) ? $default : '';
                        }
                    }
                }
            }
        }else{ // 变量默认值
            $name       =    isset($default)?$default:'';
        }
        return $name;
    }

    /**
     * array_map_recursive模拟
     * @param $filter
     * @param $data
     * @return array
     */
    public static function array_map_recursive($filter, $data) {
        $result = array();
        foreach ($data as $key => $val) {
            $result[$key] = is_array($val)
                ? self::array_map_recursive($filter, $val)
                : call_user_func($filter, $val);
        }
        return $result;
    }
}