<?php
namespace app\helpers;

class TimeHelper {
    /**
     * 获取模糊时间
     * 刚刚|分钟|小时|昨天|前天|n月j日|Y年n月j日
     * 今天|明天|n月j日|Y年n月j日
     * @param $time int|string
     * @return string|int 大于现在则为int时间戳，小于则为模糊时间
     */
    public static function getFuzzyTime($time){
        $timeZoneOffset=self::getTimeZoneOffset();
        is_numeric($time) or $time = strtotime($time);
        $now=time();
        $dayDuration=floor(($time+$timeZoneOffset)/(3600*24))-floor(($now+$timeZoneOffset)/(3600*24));
        $secondDuration=$time-$now;
        if($dayDuration==-2){
            return "前天";
        }elseif($dayDuration==-1){
            return "昨天";
        }elseif($dayDuration==0){
            if($secondDuration>0){
                return "今天";
            }elseif($secondDuration>-60){
                return "刚刚";
            }elseif($secondDuration>-3600){
                return floor(-$secondDuration/60)."分钟前";
            }else{
                return floor(-$secondDuration/3600)."小时前";
            }
        }elseif($dayDuration==1){
            return "明天";
        }elseif($dayDuration==2){
            return "后天";
        }else{
            if(date("Y",$now)!=date("Y",$time)){
                return date("Y年n月j日",$time);
            }else{
                return date("n月j日",$time);
            }
        }
    }

    /**
     * 获取时区秒数偏移量
     * @return int
     */
    private static function getTimeZoneOffset(){
        $tz=timezone_open(\Yii::$app->timeZone);
        $dateTimeOslo=date_create("now",timezone_open("Europe/Oslo"));
        return  timezone_offset_get($tz,$dateTimeOslo);
    }
} 