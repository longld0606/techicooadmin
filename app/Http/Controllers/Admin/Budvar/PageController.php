<?php

namespace App\Http\Controllers\Admin\Budvar;

use App\DataTables\BudvarPageDataTable;
use App\Http\Controllers\Admin\AdminController;

class PageController extends AdminController
{

    public function index(BudvarPageDataTable $dataTable)
    {
        return $dataTable->render('admin.budvar.page.index', []);
    }
}
