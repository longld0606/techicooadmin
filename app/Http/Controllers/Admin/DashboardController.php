<?php

namespace App\Http\Controllers\Admin; 

class DashboardController extends AdminController
{
    public function index()
    {
        // administrator 
        if(auth("admin")->user()->hasPermissionTo('Budvar', 'admin')) return redirect()->route('admin.budvar.dashboard');

        return view('admin.dashboard.index');
    }
}
