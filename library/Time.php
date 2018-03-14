<?php

/**
 * 时间相关
 * Class Time
 */
class Time
{
    /**
     * 获取一天时间戳
     * @param int $time 时间戳
     * @return array
     */
    public static function getOneDayPeriod($time = 0)
    {
        empty($time) && $time = time();
        $start_time = strtotime(date("Y-m-d",$time));
        $end_time = $start_time + 86400 - 1;
        return array("start_time"=>$start_time,"end_time"=>$end_time);
    }

    /**
     * 根据出生日期获取年龄
     * @param $birthday
     * @return int
     */
    public static function birthday($birthday){
        list($y1,$m1,$d1) = explode("-", date("Y-m-d", strtotime($birthday)));
        list($y2,$m2,$d2) = explode("-", date("Y-m-d", time()));
        $age = $y2 - $y1;
        if((int)($m2.$d2) < (int)($m1.$d1))
            $age -= 1;
        return $age;
    }

    /**
     * 根据开始时间和结束时间获取时间段数组
     * @param $startDate
     * @param $endDate
     * @param bool $getNow 是否获取当前日期范围
     * @return array
     */
    public static function getDateRang($startDate, $endDate, $getNow = true)
    {
        $activeStartDate = $startDate;
        $activeEndDate = $endDate;
        $nowDate = date('Ymd');

        $dateRang = array();
        if ($getNow) {
            // 获取当前日期范围
            if (strtotime($nowDate) < strtotime($activeStartDate)) {
                return $dateRang;
            } else if (strtotime($nowDate) >= strtotime($activeEndDate)){
                $lastDate = $activeEndDate;
            } else {
                $lastDate = $nowDate;
            }
        } else {
            // 获取日期范围
            $lastDate = $activeEndDate;
        }

        for ($date = $activeStartDate; strtotime($date) <= strtotime($lastDate); $date = date("Ymd",strtotime("$date   +1   day"))) {
            $dateRang[] = $date;
        }
        return $dateRang;
    }

}