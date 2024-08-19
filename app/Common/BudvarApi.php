<?php

/**
 * Created by PhpStorm.
 * User: TRUNGNT
 */

namespace App\Common;

use App\Models\UserConfig;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Class Utility
 * @package App\Commons
 */
class BudvarApi
{

    public static function LogApi($method, $url, $data, $response)
    {
        Log::info('Budvar api; method: ' . $method . '; Url: ' . $url . '; data:' . json_encode($data) . '; response:' . json_encode($response));
    }
    public static function toResponse($data)
    {
        if (empty($data)) return \App\Common\Response::error();
        $code = !empty($data['statusCode']) ? $data['statusCode'] : 404;
        $message  = '';
        if (!empty($data['message'])) {
            $t = gettype($data['message']);
            if ($t == 'array') $message = $data['message'][0];
            else if ($t == 'NULL') $message = '';
            else
                $message = strval($data['message']);
        }
        $arrr = !empty($data['data']) ? $data['data'] : [];

        return  new \App\Common\Response($code, $message, $arrr);
    }

    public static function get($url, $data = null)
    {
        //$token = BudvarApi::accessToken();
        $response =  Http::acceptJson()
            ->get(env('API_BUDVAR', '') . $url, $data);
        BudvarApi::LogApi("GET", $url, $data, $response);
        return BudvarApi::toResponse($response->json());
    }


    public static function post($url, $data)
    {
        $response =  Http::withToken(BudvarApi::accessToken())
            ->post(env('API_BUDVAR', '') . $url, $data);

        BudvarApi::LogApi("POST", $url, $data, $response);
        return  BudvarApi::toResponse($response->json());
    }

    public static function put($url, $data)
    {
        $response =  Http::withToken(BudvarApi::accessToken())
            ->put(env('API_BUDVAR', '') . $url, $data);
        BudvarApi::LogApi("PUT", $url, $data, $response);
        return BudvarApi::toResponse($response->json());
    }

    public static function delete($url)
    {
        $response =  Http::withToken(BudvarApi::accessToken())
            ->delete(env('API_BUDVAR', '') . $url, []);
        BudvarApi::LogApi("DELETE", $url, [], $response);
        return BudvarApi::toResponse($response->json());
    }


    public static function postMultipartFile($url, $data, $file)
    {
        if (empty($file))
            return BudvarApi::postMultipart($url, $data);

        $file_contents = file_get_contents($file->getRealPath());
        $file_name = $file->getClientOriginalName();

        $response =  Http::withToken(BudvarApi::accessToken())
            ->asMultipart()
            ->attach('file', $file_contents,  $file_name)
            ->post(env('API_BUDVAR', '') . $url, $data);
        BudvarApi::LogApi("POST", $url, $data, $response);
        return BudvarApi::toResponse($response->json());
    }

    public static function postMultipart($url, $data)
    {
        $response =  Http::withToken(BudvarApi::accessToken())
            ->asMultipart()
            ->post(env('API_BUDVAR', '') . $url, $data);
        BudvarApi::LogApi("POST", $url, $data, $response);
        return BudvarApi::toResponse($response->json());
    }

    public static function putMultipartFile($url, $data, $file)
    {
        if (empty($file))
            return BudvarApi::putMultipart($url, $data);

        $file_contents = file_get_contents($file->getRealPath());
        $file_name = $file->getClientOriginalName();

        $response =  Http::withToken(BudvarApi::accessToken())
            ->asMultipart()
            ->attach('file', $file_contents, $file_name)
            ->put(env('API_BUDVAR', '') . $url, $data);
        BudvarApi::LogApi("PUT", $url, $data, $response);
        return BudvarApi::toResponse($response->json());
    }

    public static function putMultipart($url, $data)
    {       
        $response =  Http::withToken(BudvarApi::accessToken())
            ->asMultipart()
            ->put(env('API_BUDVAR', '') . $url, $data);
        BudvarApi::LogApi("PUT", $url, $data, $response);
        return BudvarApi::toResponse($response->json());
    }


    public static function accessToken()
    {
        if (!empty(session('budvar_access_token'))) {
            return session('budvar_access_token');
        }
        $user = Auth::user();
        $config = UserConfig::query()->where('tenant', 'Budvar')->where('user_id', $user->id)->first();
        if (!$config instanceof UserConfig) {
            return '';
        }

        $response = Http::retry(5, 300)
            ->asForm()
            ->post(env('API_BUDVAR', '') . '/auth/login', ['phone' => $config->username, 'password' => $config->password]);
        $data = $response->json();
        $token = '';
        if (!empty($data) && $data['statusCode'] == 201) {
            $token = $data['data']['access_token'];
            session(['budvar_access_token' => $token]);
            return $token;
        }
        return '';
    }
}
