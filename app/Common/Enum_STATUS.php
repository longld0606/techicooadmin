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
class Enum_STATUS
{
    const ACTIVE = 'ACTIVE';
    const NOACTIVE = 'NOACTIVE';

    private static $messages = array(
        // [Informational 1xx]
        'ACTIVE' => 'Sử dụng',
        'NOACTIVE' => 'Khóa'
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
