<?php

namespace App\Http\Controllers\Budvar;

use App\Common\Utility;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;

class BudvarController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    { 
        if (Request::method() == "GET") {
            //dd($request);
            $ctrl = Utility::getRouterName(Request::route()->getName());
            View::share('ctrl', $ctrl);
            $nav = Utility::getNavView(Request::route()->getName());
            View::share('nav', $nav);
            $title = Utility::getViewTitle(Request::route()->getName());
            View::share('title', $title);
        }
    }
}
