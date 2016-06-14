<?php


namespace CampusAppointment\Helper;


class DateUtils
{
    protected static $timezone;
    protected static $immutableList = [];

    public static function setTimezone(\DateTimeZone $timeZone)
    {
        self::$timezone = $timeZone;
    }

    public static function getLocal($src)
    {
        return new \DateTime($src, self::$timezone);
    }

    public static function getImmutable($src)
    {
        return self::$immutableList[$src] ?? (self::$immutableList[$src] = new \DateTimeImmutable($src, self::$timezone));
    }

    public static function getVariableToday()
    {
        return self::getLocal('today');
    }

    public static function getVariableNow()
    {
        return self::getLocal('now');
    }

    public static function getImmutableToday()
    {
        return self::getImmutable('today');
    }

    public static function getImmutableNow()
    {
        return self::getImmutable('now');
    }

    /**
     * Convert HH:MM(:SS) to seconds in a day
     * @param string $str
     * @return int
     */
    public static function convertTimeToDaySec(string $str){
        switch (substr_count($str, ':')){
            case 2:
                list($h, $m, $s) = explode(':', $str);
                break;
            case 1:
                list($h, $m) = explode(':', $str);
                $s = 0;
                break;
            default:
                throw new \InvalidArgumentException("需要 HH:MM 时间格式！#1");
        }
        if(($ih = intval($h)) <> $h) throw new \InvalidArgumentException('需要 HH:MM 时间格式！#2-1');
        if(($im = intval($m)) <> $m) throw new \InvalidArgumentException('需要 HH:MM 时间格式！#2-2');
        $is = intval($s);
        if($ih >= 0 && $ih < 24 && $im >= 0 && $im < 60 && $is >= 0 && $is < 60){
            return $ih * 3600 + $im * 60 + $is;
        }else{
            throw new \InvalidArgumentException("需要 HH:MM 时间格式！#3");
        }
    }

    /**
     * Convert seconds in a day to HH:MM
     * @param int $val
     * @return string
     */
    public static function convertDaySecToTime(int $val){
        if($val < 0 || $val >= 86400) throw new \InvalidArgumentException("需要 0<=x<86400 的整数！");
        $h = (int) ($val / 3600);
        $m = (int) (($val - 3600 * $h) / 60);
        $s = (int) ($val - 3600 * $h - 60 * $m);
        return $s > 0 ? sprintf('%02u:%02u:%02u', $h, $m, $s) : sprintf('%02u:%02u', $h, $m);
    }

    public static function getDaySecNow()
    {
        return static::convertTimeToDaySec(static::getImmutableNow()->format('H:i:s'));
    }
}