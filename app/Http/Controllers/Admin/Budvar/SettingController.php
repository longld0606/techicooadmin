<?php

namespace App\Http\Controllers\Admin\Budvar;

use App\Common\BudvarApi;
use App\DataTables\BudvarSettingDataTable;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Budvar\Brand;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SettingController extends AdminController
{

    public function index()
    {
        return view('admin.budvar.setting.item');
    }

    public function update(FormRequest $request)
    {

        return redirect()->back()->withInput()->withErrors(['message' => $response->message ?? 'Có lỗi trong quá trình xử lý!']);
    }
}
