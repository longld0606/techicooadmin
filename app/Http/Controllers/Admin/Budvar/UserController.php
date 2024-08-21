<?php

namespace App\Http\Controllers\Admin\Budvar;

use App\Common\BudvarApi;
use App\DataTables\BudvarUserDataTable;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Budvar\Brand;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends AdminController
{

    public function index(BudvarUserDataTable $dataTable)
    {
        return $dataTable->render('admin.budvar.user.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = ['fullname' => '', 'status' => 'A'];
        return view('admin.budvar.user.item', ['isAction' => 'create', 'item' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormRequest $request)
    {
        //  
        $json = [
            'fullname' => $request->get('fullname'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'status' => $request->get('status'),
        ];
        $response = BudvarApi::post('/user/create', $json);
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Thêm thông tin User thành công');
            }
            return redirect()->route('admin.budvar.user.index')->with('success', 'Thêm thông tin User thành công');
        }
        return redirect()->back()->withInput()->withErrors(['message' => $response->message ?? 'Có lỗi trong quá trình xử lý!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = BudvarApi::get('/user/findOne/' . $id);
        $item = $data->data; 
        return view('admin.budvar.user.item', ['isAction' => 'show', 'item' =>  $item]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = BudvarApi::get('/user/findOne/' . $id);
        $item = $data->data; 
        return view('admin.budvar.user.item', ['isAction' => 'edit', 'item' =>  $item]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormRequest $request, string $id)
    {
        $json = [
            'fullname' => $request->get('fullname'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'status' => $request->get('status'),
        ];
        $response = BudvarApi::put('/user/update/' . $id, $json);
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Chỉnh sửa thông tin User thành công');
            }
            return redirect()->route('admin.budvar.user.index')->with('success', 'Chỉnh sửa thông tin User thành công');
        }

        return redirect()->back()->withInput()->withErrors(['message' => 'Có lỗi trong quá trình xử lý!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = BudvarApi::delete('/user/remove/' . $id);
        if ($response->status == 'success') {
            return response()->json(\App\Common\Response::success());
        }
        return response()->json(\App\Common\Response::error('Có lỗi trong quá trình xử lý!'));
    }
}
