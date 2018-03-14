<?php

/**
 * 输入相关
 * Class Input
 */
class Input
{
    /**
     * 判断用户是否是手机访问
     * @return bool
     */
    public static function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset($_SERVER['HTTP_VIA'])) {
            //找不到为flase,否则为true
            if(stristr($_SERVER['HTTP_VIA'], "wap")) {
                return true;
            }
        }
        //脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $clientKeyWords = array (
                'nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile',
                'phone',
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientKeyWords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        //协议法，有可能不准确
        if (isset($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }

    /**
     * 根据用户UA标示判断来源
     * @return string
     */
    public static function getUserAgentSource()
    {
        $uaSource = '';
        if(isset($_SERVER['HTTP_USER_AGENT'])){
            $ua = $_SERVER['HTTP_USER_AGENT'];
            if(stripos($ua, 'MicroMessenger') !== false){
                $uaSource = 'wx';
            }elseif(stripos($ua, 'MQQBrowser')!==false || stripos($ua, 'QQ')!==false || stripos($ua, 'Qzone')!==false){
                $uaSource = 'qq';
            }elseif(stripos($ua, 'Weibo') !== false){
                $uaSource = 'wb';
            }
        }
        return $uaSource;
    }

    /**
     * 根据用户UA标示判断手机系统
     * @return string
     */
    public static function getUserSystem()
    {
        $uaSystem = 'unknown';
        if(isset($_SERVER['HTTP_USER_AGENT'])){
            $ua  = strtolower($_SERVER["HTTP_USER_AGENT"]);
            if(stripos($ua, 'windows nt')!==false){
                $uaSystem = 'windows';
            }elseif(stripos($ua, 'android')!==false){
                $uaSystem = 'android';
            }elseif(stripos($ua, 'iphone')!==false || stripos($ua, 'ipad')!==false || stripos($ua, 'ipod')!==false){
                $uaSystem = 'ios';
            }
        }
        return $uaSystem;
    }

    /**
     * 获取客户端ip
     * 访问时用localhost访问的，读出来的是“::1”是正常情况。
     * ：：1说明开启了ipv6支持,这是ipv6下的本地回环地址的表示。
     * 使用ip地址访问或者关闭ipv6支持都可以不显示这个。
     */
    public static function getClientIP()
    {
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR')) {
                $ip = getenv('HTTP_X_FORWARDED_FOR');
            } elseif (getenv('HTTP_CLIENT_ip')) {
                $ip = getenv('HTTP_CLIENT_ip');
            } else {
                $ip = getenv('REMOTE_ADDR');
            }
        }
        if(trim($ip)=='::1'){
            $ip='127.0.0.1';
        }
        return $ip;
    }

    /**
     * 判断是否是safari
     * @return bool
     */
    public static function is_safari(){
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        if(strpos($agent, 'safari')) {
            return true;
        }
        return false;
    }

    /**
     * 根据用户UA标示获取ios版本号
     * @return int
     */
    public static function getIosVersion()
    {
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        preg_match("/iphone os ([0-9_]+)/i",$agent,$all);
        if(!empty($all[1])) {
            return $all[1];
        }
        return 0;
    }

    /**
     * 根据用户UA标示获取Android版本号
     * @return int
     */
    public static function getAndroidVersion()
    {
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        preg_match("/Android ([0-9\.]+)/i",$agent,$all);
        if(!empty($all[1])) {
            return $all[1];
        }
        return 0;
    }

}