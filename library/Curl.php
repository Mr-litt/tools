<?php

/**
 * CURL请求类
 * Class Curl
 */
class Curl
{

    /**
     * post
     * @param $url
     * @param array $postFields
     * @param array $header
     * @return mixed
     */
    public static function post($url,$postFields=[],$header =[]){
        if(is_array($postFields)) $postFields = http_build_query($postFields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * get
     * @param $url
     * @param array $getFields
     * @return mixed
     */
    public static function get($url,$getFields=[]){
        $getFields = http_build_query($getFields);
        $ch = curl_init();
        $url .='?'.$getFields;
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}