<?php

namespace App\Http\Middleware;

use App\Models\Logs;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Logger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $contents = json_decode($response->getContent(), true, 512);

        $headers  = $request->header();

        if (str_contains(trim($request->getPathInfo(), '/'), "assets")) return $response;
        if (str_contains(trim($request->getPathInfo(), '/'), "vendor")) return $response;

        $dt = new Carbon();

        $data = [
            'path'         => $request->getPathInfo(),
            'method'       => $request->getMethod(),
            'ip'           => $request->ip(),
            'http_version' => $_SERVER['SERVER_PROTOCOL'],
            'timestamp'    => $dt->toDateTimeString(),
            'headers'      => [
                // get all the required headers to log
                'user-agent' => isset($headers['user-agent']) ?  $headers['user-agent'] : '',
                'referer'    => isset($headers['referer']) ?  $headers['referer'] : '',
                'origin'     => isset($headers['origin']) ?  $headers['origin'] : '',
            ],
        ];

        // if request if authenticated
        if ($request->user()) {
            $data['user_id'] = $request->user()->id;
            $data['user_name'] = $request->user()->name;
        }
        $isDataTable = false;
        // if you want to log all the request body
        if (count($request->all()) > 0) {
            // keys to skip like password or any sensitive information
            $hiddenKeys = ['password'];
            $data['request'] = $request->except($hiddenKeys);
            if (isset($data['request']['draw']) && isset($data['request']['columns'])) {
                $isDataTable = true;
            }
            $data['request']['ajax'] = $request->ajax();
        }

        // không log response DataTable  // return the response
        if ($isDataTable == true) return $response;

        // to log the message from the response
        if (!empty($contents['code'])) {
            $data['response']['code'] = $contents['code'];
        }
        if (!empty($contents['status'])) {
            $data['response']['status'] = $contents['status'];
        }
        if (!empty($contents['message'])) {
            $data['response']['message'] = $contents['message'];
        }
        if (!empty($contents['data'])) {
            $data['response']['data'] = $contents['data'];
        }
        // to log the errors from the response in case validation fails or other errors get thrown
        if (!empty($contents['errors'])) {
            $data['response']['errors'] = $contents['errors'];
        }
        // to log the data from the response, change the RESULT to your API key that holds data
        if (!empty($contents['result'])) {
            $data['response']['result'] = $contents['result'];
        }


        // a unique message to log, I prefer to save the path of request for easy debug
        $message = str_replace('/', '_', trim($request->getPathInfo(), '/'));

        // log the gathered information
        Log::info($message, $data);
        if ((bool) env('APP_DEBUG', false)) {
            $dblogs = new Logs();
            if (isset($data['user_id'])) $dblogs->user_id =  $data['user_id'];
            if (isset($data['user_name'])) $dblogs->user_name = $data['user_name'];

            $dblogs->timestamp = $data['timestamp'];
            $dblogs->ip = $data['ip'];
            $dblogs->http_version = $data['http_version'];
            $dblogs->path = $data['path'];
            $dblogs->method = $data['method'];
            $dblogs->headers = json_encode($data['headers'], JSON_UNESCAPED_UNICODE);
            $dblogs->request = isset($data['request']) ? json_encode($data['request'], JSON_UNESCAPED_UNICODE) : '';

            $dblogs->response_code  =  isset($data['response']['code']) ? json_encode($data['response']['code'], JSON_UNESCAPED_UNICODE) : '';
            $dblogs->response_message =  isset($data['response']['message']) ? json_encode($data['response']['message'], JSON_UNESCAPED_UNICODE) : '';
            $dblogs->response =  isset($data['response']) ? json_encode($data['response'], JSON_UNESCAPED_UNICODE) : '';

            $dblogs->created_at = time();
            $dblogs->save();
        }

        // return the response
        return $response;
    }
}
