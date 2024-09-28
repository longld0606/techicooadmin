<?php

/**
 * Created by PhpStorm.
 * User: TRUNGNT
 */

namespace App\Common;

use App\Models\UserConfig;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Class Utility
 * @package App\Commons
 */
class BudvarApi
{

    public static function LogApi($method, $url, $data, $response, $type = "none")
    {
        if ($type == "json")
            Log::info('Budvar api; method: ' . $method . '; Url: ' . $url . '; data:' . json_encode($data) . '; response:' . json_encode($response));
        else
            Log::info('Budvar api; method: ' . $method . '; Url: ' . $url . '; data:' . json_encode($data) . '; response:' . json_encode($response->json()));
    }
    public static function toResponse($data)
    {
        if (empty($data)) return \App\Common\Response::error();
        $code = !empty($data['statusCode']) ? $data['statusCode'] : 404;
        $message  = '';
        $arrrData = [];
        //dd($data);
        if ($data['statusCode'] < 200 || $data['statusCode'] >= 300) {
            $_type = gettype($data['data']['message']);
            if ($_type == 'array') $message = join("; ", $data['data']['message']);
            else if ($_type == 'NULL') $message = '';
            else
                $message = strval($data['data']['message']);
        } else {
            $arrrData = !empty($data['data']) ? $data['data'] : [];
        }

        return  new \App\Common\Response($code, $message, $arrrData);
    }

    public static function get($url, $data = null)
    {
        //$token = BudvarApi::accessToken();
        $response =  Http::acceptJson()
            ->get(env('API_BUDVAR', '') . $url, $data);
        // BudvarApi::LogApi("GET", $url, $data, $response);
        return BudvarApi::toResponse($response->json());
    }


    public static function post($url, $data)
    {
        $response =  Http::withToken(BudvarApi::accessToken())
            ->post(env('API_BUDVAR', '') . $url, $data);

        BudvarApi::LogApi("POST", $url, $data, $response);
        //var_dump($data);
        //dd($response->json());
        return  BudvarApi::toResponse($response->json());
    }

    public static function put($url, $data)
    {
        $response =  Http::withToken(BudvarApi::accessToken())
            ->put(env('API_BUDVAR', '') . $url, $data);
        BudvarApi::LogApi("PUT", $url, $data, $response);
        //var_dump($data);
        //dd($response->json());
        return BudvarApi::toResponse($response->json());
    }

    public static function delete($url)
    {
        $response =  Http::withToken(BudvarApi::accessToken())
            ->delete(env('API_BUDVAR', '') . $url, []);
        BudvarApi::LogApi("DELETE", $url, [], $response);
        return BudvarApi::toResponse($response->json());
    }


    public static function postMultipartFile($url, $data, $files)
    {
        if (empty($files))
            return BudvarApi::postMultipart($url, $data);

        $response =  Http::withToken(BudvarApi::accessToken())
            ->asMultipart();
        if (gettype($files) == 'array') {
            foreach ($files as $k => $file) {
                $file_name = $file->getClientOriginalName();
                $response = $response->attach('files', $file, $file_name);
            }
        } else {
            $file_contents = file_get_contents($files->getRealPath());
            $file_name = $files->getClientOriginalName();
            $response = $response->attach('file', $file_contents,  $file_name);
        }
        $response =  $response->post(env('API_BUDVAR', '') . $url, $data);
        BudvarApi::LogApi("POST", $url, $data, $response);
        return BudvarApi::toResponse($response->json());
    }

    public static function putMultipartFile($url, $data, $files)
    {
        if (empty($files))
            return BudvarApi::putMultipart($url, $data);
        $response =  Http::withToken(BudvarApi::accessToken());
        if (gettype($files) == 'array') {
            foreach ($files as $k => $file) {
                $file_contents = file_get_contents($file->getRealPath());
                $file_name = $file->getClientOriginalName();
                $response = $response->attach('files', $file_contents, $file_name);
            }
        } else {
            $file_contents = file_get_contents($files->getRealPath());
            $file_name = $files->getClientOriginalName();
            $response = $response->attach('file', $file_contents,  $file_name);
        }
        $response =  $response->put(env('API_BUDVAR', '') . $url, $data);
        BudvarApi::LogApi("PUT", $url, $data, $response);
        return BudvarApi::toResponse($response->json());
    }

    // ==============================================================================================================================

    public static function toMultipart($body)
    {
        $data['multipart'] = [];
        foreach ($body as $key => $value) {
            if (gettype($value) == 'array') {
                foreach ($value as $k =>  $v) {
                    if (isset($v) && file_exists($v)) {
                        $file_contents = file_get_contents($v->getRealPath());
                        $file_name = $v->getClientOriginalName();
                        array_push($data['multipart'], [
                            'name' => $key,
                            'contents' => $file_contents,
                            'filename' => $file_name
                        ]);
                    } else {
                        array_push($data['multipart'], [
                            'name' => $key . "[]",
                            'contents' =>  $v,
                        ]);
                    }
                }
            } else if (gettype($value) == 'string') {
                array_push($data['multipart'], [
                    'name' => $key,
                    'contents' => $value,
                ]);
            } else if (isset($value)) {
                array_push($data['multipart'], [
                    'name' => $key,
                    'contents' => $value,
                ]);
            }
        }
        return $data;
    }
    public static function putMultipart($url, $data)
    {
        $client = new Client();
        $headers = ['Authorization' => 'Bearer ' . BudvarApi::accessToken()];
        $multipart_data = BudvarApi::toMultipart($data);
        $request = new Request('PUT', env('API_BUDVAR', '') . $url, $headers);
        $response = $client->send($request, $multipart_data)->getBody()->getContents();
        //var_dump(json_encode($multipart_data));
        //dd(BudvarApi::accessToken());
        $json = json_decode($response, true);
        BudvarApi::LogApi("PUT", $url, $data, $json, 'json');
        return BudvarApi::toResponse($json);
    }
    public static function postMultipart($url, $data)
    {
        $client = new Client();
        $headers = ['Authorization' => 'Bearer ' . BudvarApi::accessToken()];
        $multipart_data = BudvarApi::toMultipart($data);
        $request = new Request('POST', env('API_BUDVAR', '') . $url, $headers);
        $response = $client->send($request, $multipart_data)->getBody()->getContents();
        $json = json_decode($response, true);
        BudvarApi::LogApi("POST", $url, $data, $json, 'json');
        return BudvarApi::toResponse($json);
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
