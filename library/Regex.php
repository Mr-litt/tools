<?php

/**
 * Created by IntelliJ IDEA.
 * User: lihaitao
 * Date: 17-5-9
 * Time: 下午3:30
 */
class Regex
{
    public static function validate($value,$rule) {
        $validate = array(
            'require'   =>  '/.+/',
            'email'     =>  '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
            'url'       =>  '/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/',
            'currency'  =>  '/^\d+(\.\d+)?$/',
            'number'    =>  '/^\d+$/',
            'zip'       =>  '/^\d{6}$/',
            'integer'   =>  '/^[-\+]?\d+$/',
            'double'    =>  '/^[-\+]?\d+(\.\d+)?$/',
            'english'   =>  '/^[A-Za-z]+$/',
            'mobile'	=>	"/^1[35748][0-9]{9}$/",
            //-------------------------
            'intege'	=>	"/^-?[1-9]\d*$/",					//整数
            'intege1'	=>	"/^[1-9]\d*$/",					//正整数
            'intege2'	=>	"/^-[1-9]\d*$/",					//负整数
            'num'		=>	"/^-?(\d+|\d+\.\d+)$/",			//数字
            'num1'		=>	"/^([1-9]\d*|0)$/",					//正数（正整数 + 0）
            'num2'		=>	"/^(-[1-9]\d*|0)?$/",					//负数（负整数 + 0）
            'decmal'	=>	"/^[+-]?\d*\.\d+$/",			//浮点数
            'decmal1'	=>	"/^([1-9]\d*\.\d+|0\.\d+)$/",//正浮点数
            'decmal2'	=>	"/^-([1-9]\d*\.\d+|0\.\d+)$/",//负浮点数
            'decmal3'	=>	"/^-?\d*\.\d+$/",//浮点数
            'decmal4'	=>	"/^([1-9]\d*\.\d+|0\.\d+|0)$/",//非负浮点数(正浮点数+0)
            'decmal5'	=>	"/^-([1-9]\d*\.\d+|0\.\d+|0)$/",//非正浮点数(负浮点数+0)
            'color'		=>	"/^[a-fA-F0-9]{6}$/",//颜色
            'isnotempty'=>	"/\S+/", //非空字符串
            'num3'		=>	"/^([1-9]\d*|[1-9]\d*\.\d+|0\.\d+)?$/",  //正数（整数+浮点数）
        );
        // 检查是否有已定义好的正则
        if(isset($validate[strtolower($rule)]))
            $rule       =   $validate[strtolower($rule)];
        return preg_match($rule,$value)===1;
    }
}