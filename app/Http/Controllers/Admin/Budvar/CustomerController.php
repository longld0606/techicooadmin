<?php

namespace App\Http\Controllers\Admin\Budvar;

use App\Common\ApiInputModel;
use App\Common\BudvarApi;
use App\DataTables\BudvarCustomerDataTable;
use App\Http\Controllers\Admin\AdminController;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CustomerController extends AdminController
{

    // public function __construct()
    // {
    //     parent::__construct();
    // }
    
    protected function instanceInputs($isData = true)
    {
        $inputs = [];
        $inputs[] = ApiInputModel::input('Họ tên', 'fullname', 'val', 6, true);
        $inputs[] = ApiInputModel::input('Email', 'email', 'email', 6, true);
        $inputs[] = ApiInputModel::input('Số điện thoại', 'phoneNumber', 'val', 6, true);
        $inputs[] = ApiInputModel::input('Ngày sinh', 'birthday', 'date', 6, false);
        $inputs[] = ApiInputModel::select('Giới tính', 'gender', 6, ['other' => 'Không xác định', 'male' => 'Nam', 'female' => 'Nữ'], '', false);
        $inputs[] = ApiInputModel::row();
        $inputs[] = ApiInputModel::input('Mật khẩu', 'password', 'password', 6, true);
        $inputs[] = ApiInputModel::input('Nhập lại khẩu', 'repassword', 'password', 6, true);
        $inputs[] = ApiInputModel::input('Địa chỉ', 'address', 'val', 12, false);
        // $inputs[] = ApiInputModel::select('Trạng thái', 'status', 6, ['A' => 'A', 'F' => 'F'], '', true);
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
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(FormRequest $request)
    {
        $inputs = $this->instanceInputs(false);
        $json = [];
        foreach ($inputs as $inp) {
            if ($inp->type == 'row' || $inp->type == 'line') continue;
            $val = $request->get($inp->name);
            if ($inp->type == 'date') {
                $json[$inp->name] = Carbon::createFromFormat('d/m/Y', $val)->format('Y-m-d');
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
            if ($inp->type == 'row' || $inp->type == 'line') continue;
            $val = $request->get($inp->name);
            if ($inp->type == 'date') {
                $json[$inp->name] = Carbon::createFromFormat('d/m/Y', $val)->format('Y-m-d');
            } else {
                $json[$inp->name] = $request->get($inp->name);
            }
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


    public function address(Request $request)
    {
        $q = $request->query('query');
        //$url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?key='.env('GOOLE_MAPS_API_KEY', '').'&query='.$q ;        
        //$response = Http::get( $url);
        //var_dump($response->json());
        //dd($response);
        $data = [];
        $data[] = ['value' => 'Hà nội', 'data' => ' hà nội việt nam', 'lat' => 123.444, 'long' => 12344];
        $data[] = ['value' => 'thanh hóa', 'data' => ' thanh  hoa việt nam', 'lat' => 123.444, 'long' => 12344];
        return response()->json(['query' => $q, 'suggestions' => $data]);
    }
}