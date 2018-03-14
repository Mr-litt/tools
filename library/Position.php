<?php

class Position
{
    /**
     * 根据ip获取经纬度
     * @param $ip
     * @return array
     */
    public static function getLatAndLngByIp($ip)
    {
        if (empty($ip)) {
            return array(0, 0);
        }
        $content = file_get_contents("http://api.map.baidu.com/highacciploc/v1?qcip=$ip&qterm=pc&ak=请输入您的AK&coord=bd09ll");
        $json = (array)json_decode($content, true);
        $lng = $json['content']['location']['lng'];// 提取经度数据
        $lat = $json['content']['location']['lat'];// 提取纬度数据
        return array($lat, $lng);
    }

    /**
     * 根据ip获取国家
     * @param $ip
     * @return mixed|string
     */
    public static function getAddressByIp($ip)
    {
        $address = Ip::find($ip);
        return $address;
    }

    /**
     * 根据国家获取区号
     * @param $country
     * @return mixed
     */
    public static function getCodeByAddress($country)
    {
        $countryToCodeArr = include "countryCode/countryToCode.php";
        $country == '澳门' && $country = '中国澳门特别行政区';
        $country == '香港' && $country = '中国香港特别行政区';
        return $countryToCodeArr[$country];
    }


}