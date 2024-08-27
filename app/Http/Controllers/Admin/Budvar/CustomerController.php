<?php

namespace App\Http\Controllers\Admin\Budvar;

use App\Common\ApiInputModel;
use App\Common\BudvarApi;
use App\DataTables\BudvarCustomerDataTable;
use App\Http\Controllers\Admin\AdminController;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest; 

class CustomerController extends AdminController
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function instanceInputs($isData = true)
    {
        $inputs = [];
        $inputs[] = ApiInputModel::input('Năm', 'year', 'val', 6, true);
        $inputs[] = ApiInputModel::input('Tiêu đề', 'topic', 'val', 6, true);
        $inputs[] = ApiInputModel::select('Ngôn ngữ', 'lang', 6, \App\Common\Enum_LANG::getArray(), '', true);
        $inputs[] = ApiInputModel::input('Mô tả', 'description', 'text', 12, true); 
        return $inputs;
    }

    public function index(BudvarCustomerDataTable $dataTable)
    {
        return $dataTable->render('admin.budvar.customer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = ['title' => '', 'status' => 'A'];
        return view('admin.budvar.customer.item', ['isAction' => 'create', 'item' => $data, 'inputs' => $this->instanceInputs()]);
    }

    protected function storeImage(FormRequest $request)
    {
        $file_str = $request->file('thumb')->store('public/budvar/customer');
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
                $json[$inp->name] = Carbon::createFromFormat('d/m/Y',$val)->format('Y-m-d');
            } else {
                $json[$inp->name] = $request->get($inp->name);
            }
        }
        $response = BudvarApi::post('/customer/create', $json); 
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Thêm thông tin Customer thành công');
            }
            return redirect()->route('admin.budvar.customer.index')->with('success', 'Thêm thông tin Customer thành công');
        }
        return redirect()->back()->withInput()->withErrors(['message' => $response->message ?? 'Có lỗi trong quá trình xử lý!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = BudvarApi::get('/customer/findOne/' . $id);
        $item = $data->data;
        if (empty($item['type'])) $item['type'] = 'BANNER';
        return view('admin.budvar.customer.item', ['isAction' => 'show', 'item' =>  $item, 'inputs' => $this->instanceInputs()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = BudvarApi::get('/customer/findOne/' . $id);
        $item = $data->data;
        if (empty($item['type'])) $item['type'] = 'BANNER';
        return view('admin.budvar.customer.item', ['isAction' => 'edit', 'item' =>  $item, 'inputs' => $this->instanceInputs()]);
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
        $response = BudvarApi::put('/customer/update/' . $id, $json);
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Chỉnh sửa thông tin Customer thành công');
            }
            return redirect()->route('admin.budvar.customer.index')->with('success', 'Chỉnh sửa thông tin Customer thành công');
        }

        return redirect()->back()->withInput()->withErrors(['message' => 'Có lỗi trong quá trình xử lý!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = BudvarApi::delete('/customer/remove/' . $id);
        if ($response->status == 'success') {
            return response()->json(\App\Common\Response::success());
        }
        return response()->json(\App\Common\Response::error('Có lỗi trong quá trình xử lý!'));
    }
}
