<?php

namespace App\Http\Controllers\Web;
namespace Illuminate\Contracts\Auth;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $u = auth("admin")->user();
        if (!empty($u)) {
            if ($u->hasRole('Budvar') && !$u->hasRole('Administrator')) return redirect()->route('admin.budvar.dashboard');
        }

        return redirect()->route('admin.login');
        //return view('web.home');
    }
}
