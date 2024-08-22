<?php

namespace App\Http\Controllers\Admin\Budvar;

use App\Common\BudvarApi;
use App\DataTables\BudvarPromotionDataTable;
use App\Http\Controllers\Admin\AdminController; 
use Illuminate\Foundation\Http\FormRequest; 

class PromotionController extends AdminController
{

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
        return view('admin.budvar.promotion.item', ['isAction' => 'create', 'item' => $data]);
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
        //  
        $json = [
            'title' => $request->get('title'),
            'lang' => $request->get('lang'),
            'type' => $request->get('type'),
            'status' => $request->get('status'),
        ];
        $response = BudvarApi::post('/promotion/create', $json);
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
        return view('admin.budvar.promotion.item', ['isAction' => 'show', 'item' =>  $item]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = BudvarApi::get('/promotion/findOne/' . $id);
        $item = $data->data;
        if (empty($item['type'])) $item['type'] = 'BANNER';
        return view('admin.budvar.promotion.item', ['isAction' => 'edit', 'item' =>  $item]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormRequest $request, string $id)
    {
        $json = [
            'title' => $request->get('title'),
            'lang' => $request->get('lang'),
            'type' => $request->get('type'),
            'status' => $request->get('status'),
        ];
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
