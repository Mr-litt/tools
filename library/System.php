<?php

/**
 * 系统相关
 * Class System
 */
class System
{
    /**
     * 判断系统是否为64位系统
     * @return bool
     */
    public static function isOn64bitsSystem()
    {
        // 左移32位之后会超过32位系统的限制，如果64位系统则不会
        return (1 << 32) == 1 ? false : true;
        //return PHP_INT_SIZE === 8 ? true : false;
    }

    /**
     * 获取二进制头文件，从而得知属于什么类型文件
     * @param string $fileByte 二进制内容
     * @param string $filename 文件地址
     * @return  string
     */
    public static function getFileType($fileByte = '', $filename = '')
    {
        if ($filename != '') {
            $file = fopen($filename, "rb");
            $bin = fread($file, 2); //只读2字节
            fclose($file);
        } else {
            $bin = substr($fileByte, 0, 2);
        }

        $strInfo = @unpack("C2chars", $bin);
        $typeCode = intval($strInfo['chars1'] . $strInfo['chars2']);

        switch ($typeCode) {
            case 3533:
                $fileType = 'amr';
                break;
            case 255216:
                $fileType = 'jpg';
                break;
            case 7173:
                $fileType = 'gif';
                break;
            case 13780:
                $fileType = 'png';
                break;
            case 7790:
                $fileType = 'exe';
                break;
            case 7784:
                $fileType = 'midi';
                break;
            case 8297:
                $fileType = 'rar';
                break;
            case 8075:
                $fileType = 'zip';
                break;
            case 6677:
                $fileType = 'bmp';
                break;
            case 255249:
                $fileType = 'aac';
                break;
            default:
                $fileType = '';
                break;
        }
        //Fix
        if ($strInfo['chars1'] == '-1' && $strInfo['chars2'] == '-40') return 'jpg';
        if ($strInfo['chars1'] == '-119' && $strInfo['chars2'] == '80') return 'png';

        return $fileType;
    }
}