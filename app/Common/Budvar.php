<?php

/**
 * Created by PhpStorm.
 * User: TRUNGNT
 */

namespace App\Common;

use Illuminate\Support\Facades\Http;

/**
 * Class Utility
 * @package App\Commons
 */
class Budvar
{

    public static function toResponse($data)
    {
        $code = !empty($data['statusCode']) ? $data['statusCode'] : 404;
        $message  = !empty($data['message']) ? $data['message'] : '';
        $arrr = !empty($data['data']) ? $data['data'] : [];

        return  new \App\Common\Response($code, $message, $arrr);
    }
    public static function get($url)
    {
        $response = Http::get(env('API_BUDVAR', 'http://localhost') . $url);
        return Budvar::toResponse($response->json());
    }
}
