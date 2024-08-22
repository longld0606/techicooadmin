<?php

/**
 * Created by PhpStorm.
 * User: TRUNGNT
 */

namespace App\Common;

use \Illuminate\Support\Facades\Route;

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

    public static function displayBudvarMedia($media)
    {
        if (empty($media)) {
            return '';
        }
        $type = gettype($media);

        if ($type == 'array' && empty($media['source'])) {
            return '';
        }
        return $media['source'];
    }

    public static function getViewTitle($route){
        return $route;
    }
    public static function getCtrlName($route, $func = "")
    {
        if ($func == 'create') return "THÊM MỚI";
        if ($func == 'show') return "XEM THÔNG TIN";
        if ($func == 'edit') return "CHỈNH SỬA";
        if ($func == 'clone') return "THÊM MỚI";
        return strtoupper($route);
    }

    public static function getRouterName($route_path)
    {
        $name = str_replace('.create', "|", $route_path);
        $name = str_replace('.clone', "|", $name);
        $name = str_replace('.edit', "|", $name);
        $name = str_replace('.show', "|", $name);
        $name = str_replace('.index', "|", $name);
        $name = str_replace('.update', "|", $name);
        $name = str_replace('.destroy', "|", $name); 
        @list($v) = explode('|', $name);
        return $v;
    }

    public static function getNavView($route_path)
    {
        $array = [];
        $paths = explode('.', $route_path);
        $r = Utility::getRouterName($route_path);
        foreach ($paths as $v) {
            if ($v == 'admin' && Route::has('admin.dashboard')) $array['HOME'] = route('admin.dashboard');
            else if ($v == 'budvar' && Route::has('admin.budvar.dashboard'))  $array['BUDVAR'] = route('admin.budvar.dashboard');
            else if ($v == 'techicoo' && Route::has('admin.techicoo.dashboard'))  $array['TECHICOO'] = route('admin.techicoo.dashboard');
            else if (($v == 'create' || $v == 'clone' || $v == 'show' || $v == 'edit')  ){
                // thêm, sửa, xóa
                $array[Utility::getCtrlName($route_path, $v)] = '#';
            } else if ($v != 'index' && Route::has($r . '.index')) {
                $array[Utility::getCtrlName($v)] = route($r . '.index');
            }
        } 
        // check budvar  
        return $array;
    }
}
