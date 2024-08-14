<?php

namespace App\Http\Controllers\Admin\Budvar;

use App\Http\Controllers\Admin\AdminController;

class DashboardController extends AdminController
{
    public function index()
    {
        return view('admin.budvar.dashboard');
    }
}
