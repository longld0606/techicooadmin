<?php

namespace App\Http\Controllers\Admin\Budvar;

use App\Common\ApiInputModel;
use App\Common\BudvarApi;
use App\Common\Response;
use App\DataTables\BudvarPromotionDataTable;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class PromotionController extends AdminController
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function instanceInputs($isData = true)
    {
        // $menus = [];
        // if ($isData)
        //     $menus = (BudvarApi::get('/menu/findAllCms', []))->data;
        $inputs = [];
        $inputs[] = ApiInputModel::input('Tên', 'name', 'val', 12, true);
        $inputs[] = ApiInputModel::input('Phần trăm', 'discountPercent', 'number', 6, true);
        $inputs[] = ApiInputModel::input('Giảm giá', 'discountPrice', 'number', 6, true);
        $inputs[] = ApiInputModel::input('Từ ngày', 'startDate', 'date',  6, true);
        $inputs[] = ApiInputModel::input('Đến ngày', 'dueDate', 'date', 6,  true);
        // $inputs[] = ApiInputModel::select('Ngôn ngữ', 'lang', 6, \App\Common\Enum_LANG::getArray(), '', true);
        // $inputs[] = ApiInputModel::selectList('Menu', 'menu', 6, $menus, '--Chọn trạng thái--', $id_field = '_id', $val_field = 'name', true,true);
        // $inputs[] = ApiInputModel::input('Tên ck', 'nameck', 'ckeditor', 12, true);
        // $inputs[] = ApiInputModel::input('Tên ck2', 'nameck2', 'ckeditor', 12, true);
        return $inputs;
    }

    public function index(BudvarPromotionDataTable $dataTable)
    {
        return $dataTable->render('admin.budvar.promotion.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = ['title' => '', 'status' => 'A'];
        return view('admin.budvar.promotion.item', ['isAction' => 'create', 'item' => $data, 'inputs' => $this->instanceInputs()]);
    }

    protected function storeImage(FormRequest $request)
    {
        $file_str = $request->file('thumb')->store('public/budvar/promotion');
        $path = substr($file_str, strlen('public/'));
        return $path;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(FormRequest $request)
    {
        $inputs = $this->instanceInputs(false);
        $json = [];
        foreach ($inputs as $inp) {
            $val = $request->get($inp->name);
            if ($inp->type == 'date') {
                $json[$inp->name] = Carbon::createFromFormat('d/m/Y',$val)->format('Y-m-d\TH:i:s.uP');
            } else {
                $json[$inp->name] = $request->get($inp->name);
            }
        }
        $response = BudvarApi::post('/promotion/create', $json);
        //$response = Response::error();
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Thêm thông tin Promotion thành công');
            }
            return redirect()->route('admin.budvar.promotion.index')->with('success', 'Thêm thông tin Promotion thành công');
        }
        return redirect()->back()->withInput()->withErrors(['message' => $response->message ?? 'Có lỗi trong quá trình xử lý!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = BudvarApi::get('/promotion/findOne/' . $id);
        $item = $data->data;
        if (empty($item['type'])) $item['type'] = 'BANNER';
        return view('admin.budvar.promotion.item', ['isAction' => 'show', 'item' =>  $item, 'inputs' => $this->instanceInputs()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = BudvarApi::get('/promotion/findOne/' . $id);
        $item = $data->data;
        if (empty($item['type'])) $item['type'] = 'BANNER';
        return view('admin.budvar.promotion.item', ['isAction' => 'edit', 'item' =>  $item, 'inputs' => $this->instanceInputs()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormRequest $request, string $id)
    {
        $inputs = $this->instanceInputs(false);
        $json = [];
        foreach ($inputs as $inp) {
            $json[$inp->name] = $request->get($inp->name);
        }
        $response = BudvarApi::put('/promotion/update/' . $id, $json);
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Chỉnh sửa thông tin Promotion thành công');
            }
            return redirect()->route('admin.budvar.promotion.index')->with('success', 'Chỉnh sửa thông tin Promotion thành công');
        }

        return redirect()->back()->withInput()->withErrors(['message' => 'Có lỗi trong quá trình xử lý!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = BudvarApi::delete('/promotion/remove/' . $id);
        if ($response->status == 'success') {
            return response()->json(\App\Common\Response::success());
        }
        return response()->json(\App\Common\Response::error('Có lỗi trong quá trình xử lý!'));
    }
}
