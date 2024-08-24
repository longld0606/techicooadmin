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
        try {
            $data = (BudvarApi::get('/setting/findAll', []))->data['setting']; 
        } catch (Exception $e) {
            return abort(404);
        }
    
        return view('admin.budvar.setting.item', ['data' => $data]);
    }

    public function update(FormRequest $request)
    {
        $json = $request->get('setting');
        $response = BudvarApi::put('/setting/update/', $json);
        if ($response->status == 'success') {
            return response()->json(\App\Common\Response::success());
        }
        return response()->json(\App\Common\Response::error('Có lỗi trong quá trình xử lý!'));
    }
}
