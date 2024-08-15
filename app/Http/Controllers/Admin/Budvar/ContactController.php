<?php

namespace App\Http\Controllers\Admin\Budvar;

use App\DataTables\BudvarContactDataTable;
use App\Http\Controllers\Admin\AdminController;

class ContactController extends AdminController
{

    public function index(BudvarContactDataTable $dataTable)
    {
        return $dataTable->render('admin.budvar.contact.index', []);
    }

    public function create()
    {
        return view('admin.dashboard.index');
    }
}
