<?php

namespace App\Http\Controllers\Admin; 

class DashboardController extends AdminController
{
    public function index()
    {
        // administrator 
        if(auth("admin")->user()->hasRole('Budvar') && !auth("admin")->user()->hasRole('Administrator')) return redirect()->route('admin.budvar.dashboard');

        return view('admin.dashboard.index');
    }
}
