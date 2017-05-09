<?php

/**
 * Created by IntelliJ IDEA.
 * User: lihaitao
 * Date: 17-5-9
 * Time: 下午2:14
 */
class Time
{
    /**
     * 获取一天时间端
     * @param int $time
     * @return array
     */
    public static function getOneDayPeriod($time=0)
    {
        $time == "" && $time = time();
        $start_time = strtotime(date("Y-m-d",$time));
        $end_time = $start_time+86400-1;
        return ["start_time"=>$start_time,"end_time"=>$end_time];
    }
}