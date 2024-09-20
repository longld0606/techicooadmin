<?php

namespace App\Http\Controllers\Admin\Budvar;

use App\Common\ApiInputModel;
use App\Common\BudvarApi;
use App\Common\Response;
use App\DataTables\BudvarVoucherDataTable;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class VoucherController extends AdminController
{

    // public function __construct()
    // {
    //     parent::__construct();
    // }

    protected function instanceInputs($isData = true)
    {
        $promotions = [];
        if ($isData) {
            $promotions = BudvarApi::get('/promotion/findAll', [])->data;
        }
        $inputs = [];
        $inputs[] = ApiInputModel::selectList('Khuyến mãi - Promotion', 'promotion', 6, $promotions, '', $id_field = '_id', $val_field = 'name', true, false);
        $inputs[] = ApiInputModel::select('Trạng thái', 'status', 6, ['A' => 'A', 'F' => 'F']);

        $inputs[] = ApiInputModel::input('Từ ngày', 'startDate', 'date',  6, true);
        $inputs[] = ApiInputModel::input('Đến ngày', 'endDate', 'date', 6,  true);

        $inputs[] = ApiInputModel::input('Số lượng sử dụng ', 'usageLimit', 'number', 6, true);
        $inputs[] = ApiInputModel::input('Giới hạn sử dụng', 'userLimit', 'number', 6, true);

        $inputs[] = ApiInputModel::input('Số lượng mua tối thiểu', 'minimumPurchaseAmount', 'number', 6, true);
        // $inputs[] = ApiInputModel::input('Số lượng sử dụng', 'usageCount', 'number', 6, true);
        // $inputs[] = ApiInputModel::input('status', 'status', 'val', 6, true);
        $inputs[] = ApiInputModel::text('Giới thiệu', 'description', 'text', 12, true);
        return $inputs;
    }

    public function index(BudvarVoucherDataTable $dataTable)
    {
        return $dataTable->render('admin.budvar.voucher.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $item = [];
        return view('admin.budvar.voucher.item', ['isAction' => 'create', 'item' => $item, 'inputs' => $this->instanceInputs()]);
    }

    protected function storeImage(FormRequest $request)
    {
        $file_str = $request->file('thumb')->store('public/budvar/voucher');
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
                $json[$inp->name] = Carbon::createFromFormat('d/m/Y', $val)->format('Y-m-d');
                // } else if ($inp->type == 'number') {
                //     $json[$inp->name] = (int)$request->get($inp->name);
            } else {
                $json[$inp->name] = $request->get($inp->name);
            }
        }
        $json['usageCount'] = 0;
        $response = BudvarApi::post('/voucher/create', $json);
        //$response = Response::error();
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Thêm thông tin Voucher thành công');
            }
            return redirect()->route('admin.budvar.voucher.index')->with('success', 'Thêm thông tin Voucher thành công');
        }
        return redirect()->back()->withInput()->withErrors(['message' => isset($response->message) ? $response->message :  'Có lỗi trong quá trình xử lý!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = BudvarApi::get('/voucher/findOne/' . $id);
        $item = $data->data;
        if (empty($item['type'])) $item['type'] = 'BANNER';
        return view('admin.budvar.voucher.item', ['isAction' => 'show', 'item' =>  $item, 'inputs' => $this->instanceInputs()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = BudvarApi::get('/voucher/findOne/' . $id);
        $item = $data->data;
        if (empty($item['type'])) $item['type'] = 'BANNER';
        return view('admin.budvar.voucher.item', ['isAction' => 'edit', 'item' =>  $item, 'inputs' => $this->instanceInputs()]);
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
        $response = BudvarApi::put('/voucher/update/' . $id, $json);
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Chỉnh sửa thông tin Voucher thành công');
            }
            return redirect()->route('admin.budvar.voucher.index')->with('success', 'Chỉnh sửa thông tin Voucher thành công');
        }

        return redirect()->back()->withInput()->withErrors(['message' => isset($response->message) ? $response->message : 'Có lỗi trong quá trình xử lý!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = BudvarApi::delete('/voucher/remove/' . $id);
        if ($response->status == 'success') {
            return response()->json(\App\Common\Response::success());
        }
        return response()->json(\App\Common\Response::error(isset($response->message) ? $response->message : 'Có lỗi trong quá trình xử lý!'));
    }

    public function confirm(string $id, string $customeId)
    {
        $json = [];
        $json['voucher'] = $id;
        $json['customer'] = $customeId;
        $response = BudvarApi::post('/voucher/confirm', $json);
        if ($response->status == 'success') {
            return response()->json(\App\Common\Response::success());
        }
        dd($response);
        return response()->json(\App\Common\Response::error(isset($response->message) ? $response->message : 'Có lỗi trong quá trình xử lý!'));
    }
}
