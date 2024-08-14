<?php

/**
 * Created by PhpStorm.
 * User: TRUNGNT
 */

namespace App\Common;

/**
 * Class Utility
 * @package App\Commons
 */
class Utility
{ 

    public static function displayStartEndDate($timeStart, $timeEnd, $format = 'd/m/Y')
    {
        $s = self::displayDatetime($timeStart, $format);
        $e = self::displayDatetime($timeEnd, $format);

        return $s . ' - ' . $e;
    }

    public static function displayDate($time, $format = 'd/m/Y')
    {
        return self::displayDatetime($time, $format);
    }

    public static function displayDatetime($time, $format = 'H:i d/m/Y')
    {
        if (empty($time)) {
            return '';
        }
        if (
            $time == '00:00:00 0000:00:00'
            || $time == '0000:00:00 00:00:00'
            || $time == '0000-00-00 00:00:00'
            || $time == ''
            || $time == null
            || $time == 'null'
        ) {
            return '';
        }
        if (is_numeric($time)) {
            $date = new \DateTime();
            $d = self::secs2date($time, $date);
            return $d->format($format);
            // return date($format, intval($time));
        }

        return date($format, strtotime($time));
    }

    public static function secs2date($secs, $date)
    {
        if ($secs > 2147472000)    //2038-01-19 expire dt
        {
            $date->setTimestamp(2147472000);
            $s = $secs - 2147472000;
            $date->add(new \DateInterval('PT' . $s . 'S'));
        } else
            $date->setTimestamp($secs);
        return $date;
    }

    public static function getDateFromString($date)
    {
        if (empty($date)) {
            return '';
        }

        @list($day, $month, $year) = explode('/', $date);

        return "{$year}-{$month}-{$day}";
    }
}
