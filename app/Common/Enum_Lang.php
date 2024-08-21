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
    // EN = 'en',
    // VN = 'vn',
    // CZ = 'cz',
    const VI = 'vn';
    const EN = 'en';
    const CZ = 'cz';


    private static $messages = array(
        'vn' => 'VN',
        'en' => 'EN',
        'cz' => 'CZ'
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
