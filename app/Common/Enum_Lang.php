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
class Enum_LANG
{
    const VI = 'Vi';
    const EN = 'En';
    const CZ = 'Cz';


    private static $messages = array(
        'VI' => 'Vi',
        'EN' => 'Vi',
        'CZ' => 'Cz'
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
