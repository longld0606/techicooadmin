<?php

namespace App\Common;

class Response
{
    public static function success($message = 'Thao tác thành công!', $data = [])
    {
        return response()->json([
            'status' => 'success',
            'code' => HttpStatusCode::HTTP_OK,
            'message' => $message,
            'data' => $data
        ]);
    }

    public static function error($message = 'Thao tác lỗi!', $code = HttpStatusCode::HTTP_OK, $data = [])
    {
        $message = empty($message) ? HttpStatusCode::getMessageForCode($code) : $message;

        return response()->json([
            'status' => 'error',
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }

    public static function getJson($response)
    {
        return  json_decode($response->getContent());
    }
}
