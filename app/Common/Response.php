<?php

namespace App\Common;


class Response
{
    public string $status;
    public int $code;
    public string $message;
    public mixed $data;
    public int $total;

    public function __construct($code = 200, $message = '', $data = [], $total=0)
    {
        $status = $code >= 200 &&  $code < 300 ? "success" : "error";
        $this->status = $status;
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
        $this->total = $total;
    }

    public function toResponse($code = 200, $message = 'Thao tác thành công!', $data = [])
    {
        $response = new Response($code, $message, $data); 
        return response()->json($response);
    }

    public static function success($message = 'Thao tác thành công!', $data = [])
    {
        $response = new Response(200, $message, $data);
        return ($response);
    }

    public static function error($message = 'Thao tác lỗi!', $code = HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR, $data = [])
    {
        $message = empty($message) ? HttpStatusCode::getMessageForCode($code) : $message;
        $response = new Response($code, $message, $data);
        return ($response);
    }

    public static function getJson($response)
    {
        return  json_decode($response->getContent());
    }
}
