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
class Enum_PageType
{
    const PAGE = 'PAGE';
    const EVENT = 'EVENT';


    private static $messages = array(
        'PAGE' => 'PAGE',
        'EVENT' => 'EVENT', 
    );

    public static function getMessage($code)
    {
        if (empty($code)) return "";
        return self::$messages[$code];
    }

    public static function getArray()
    {
        return self::$messages;
    }
}
