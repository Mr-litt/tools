<?php

/**
 * Created by IntelliJ IDEA.
 * User: lihaitao
 * Date: 17-5-9
 * Time: 上午11:17
 */

/**
 * 输出数据类
 * Class Output
 */
class Output
{
    const DEFAULT_OUT_DIR = "/log/prints/output";

    /**
     * 打印数据
     * @param mixed $data 数据
     * @param int $stop 是否中断程序
     * @param int $style 风格
     */
    public static function prints($data,$stop=0,$style=0){
        switch ($style){
            case 0:
                echo "<hr>";
                echo "<pre>";
                var_dump($data);
                echo "</pre>";
                break;
            case 1:
                break;
            default:
                break;
        }

        if($stop){
            exit;
        }
    }

    /**
     * 数据重定向
     * @param mixed $data 数据
     * @param string $file 从定向的文件
     * @param int $style 风格，0覆盖，1追加
     */
    public static function redirect($data,$file="",$style=0){
        $file == "" && $file = self::DEFAULT_OUT_DIR;
        switch ($style){
            case 0:
                file_put_contents($file,var_export($data, true));
                break;
            case 1:
                file_put_contents($file,var_export($data, true),FILE_APPEND);
                break;
            default:
                break;
        }
    }

}