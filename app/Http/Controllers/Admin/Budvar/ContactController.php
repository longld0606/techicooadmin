<?php

namespace App\Http\Controllers\Admin\Budvar;

use App\Common\BudvarApi;
use App\DataTables\BudvarContactDataTable;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Budvar\Contact;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ContactController extends AdminController
{

    public function index(BudvarContactDataTable $dataTable)
    {
        return $dataTable->render('admin.budvar.contact.index', []);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = ['type' => "PAGE"];
        return view('admin.budvar.contact.item', ['isAction' => 'create', 'item' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormRequest $request)
    {
        //  
        $json = [
            'firstname' => $request->get('firstname'),
            'lastname' => $request->get('lastname'),
            'type' => $request->get('type'),
            'phoneNumber' => $request->get('phoneNumber'),
            'email' => $request->get('email'),
            'turnAgree' => true,
            'message' =>  $request->get('message'),
        ];
        $response = BudvarApi::post('/contact/create', $json);
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Thêm thông tin Contact thành công');
            }
            return redirect()->route('admin.budvar.contact.index')->with('success', 'Thêm thông tin Contact thành công');
        }
        return redirect()->back()->withInput()->withErrors(['message' => $response->message ?? 'Có lỗi trong quá trình xử lý!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = BudvarApi::get('/contact/findOne/' . $id);
        $item = $data->data;
        if (empty($item['type'])) $item['type'] = 'contact';
        return view('admin.budvar.contact.item', ['isAction' => 'show', 'item' =>  $item]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = BudvarApi::get('/contact/findOne/' . $id);
        $item = $data->data;
        if (empty($item['type'])) $item['type'] = 'contact';
        return view('admin.budvar.contact.item', ['isAction' => 'edit', 'item' =>  $item]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormRequest $request, string $id)
    {
        $json = [
            'firstname' => $request->get('firstname'),
            'lastname' => $request->get('lastname'),
            'type' => $request->get('type'),
            'phoneNumber' => $request->get('phoneNumber'),
            'email' => $request->get('email'),
            'turnAgree' => true,
            'message' =>  $request->get('message'),
        ];
        $response = BudvarApi::put('/contact/update/' . $id, $json);
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Chỉnh sửa thông tin Contact thành công');
            }
            return redirect()->route('admin.budvar.contact.index')->with('success', 'Chỉnh sửa thông tin Contact thành công');
        }

        return redirect()->back()->withInput()->withErrors(['message' => 'Có lỗi trong quá trình xử lý!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = BudvarApi::delete('/contact/remove/' . $id);
        if ($response->status == 'success') {
            return response()->json(\App\Common\Response::success());
        }
        return response()->json(\App\Common\Response::error('Có lỗi trong quá trình xử lý!'));
    }
}
