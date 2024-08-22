<?php

namespace App\Http\Controllers\Admin\Budvar;

use App\Common\BudvarApi;
use App\DataTables\BudvarMenuDataTable;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Budvar\Brand;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MenuController extends AdminController
{

    public function index(BudvarMenuDataTable $dataTable)
    {
        $menus = BudvarApi::get('/menu/findAll', []);
        return $dataTable->render('admin.budvar.menu.index', ['menus' => $menus->data]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = ['title' => '', 'status' => 'A'];
        $menus = BudvarApi::get('/menu/findAllCms', []);
        return view('admin.budvar.menu.item', ['isAction' => 'create', 'item' => $data, 'menus' => $menus->data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormRequest $request)
    {
        //  
        $json = [
            'name' => $request->get('name'),
            'link' => $request->get('link'),
            'lang' => $request->get('lang'),
            'parentID' => $request->get('parentID'),
            'location' => $request->get('location'), 
            'status' => $request->get('status'), 
        ];
        $response = BudvarApi::post('/menu/create', $json);
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Thêm thông tin Menu thành công');
            }
            return redirect()->route('admin.budvar.menu.index')->with('success', 'Thêm thông tin Menu thành công');
        }
        return redirect()->back()->withInput()->withErrors(['message' => $response->message ?? 'Có lỗi trong quá trình xử lý!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = BudvarApi::get('/menu/findOne/' . $id);
        $item = $data->data;
        if (empty($item['type'])) $item['type'] = 'BANNER';
        $menus = BudvarApi::get('/menu/findAllCms', []);
        return view('admin.budvar.menu.item', ['isAction' => 'show', 'item' =>  $item, 'menus' => $menus->data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = BudvarApi::get('/menu/findOne/' . $id);
        $item = $data->data;
        if (empty($item['type'])) $item['type'] = 'BANNER';
        $menus = BudvarApi::get('/menu/findAllCms', []);
        return view('admin.budvar.menu.item', ['isAction' => 'edit', 'item' =>  $item, 'menus' => $menus->data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormRequest $request, string $id)
    {
        $json = [
            'name' => $request->get('name'),
            'link' => $request->get('link'),
            'lang' => $request->get('lang'),
            'parentID' => $request->get('parentID'),
            'location' => $request->get('location'), 
            'status' => $request->get('status'), 
        ];
        $response = BudvarApi::put('/menu/update/' . $id, $json);
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Chỉnh sửa thông tin Menu thành công');
            }
            return redirect()->route('admin.budvar.menu.index')->with('success', 'Chỉnh sửa thông tin Menu thành công');
        }

        return redirect()->back()->withInput()->withErrors(['message' => 'Có lỗi trong quá trình xử lý!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = BudvarApi::delete('/menu/remove/' . $id);
        if ($response->status == 'success') {
            return response()->json(\App\Common\Response::success());
        }
        return response()->json(\App\Common\Response::error('Có lỗi trong quá trình xử lý!'));
    }
}
