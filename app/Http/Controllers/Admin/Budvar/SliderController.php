<?php

namespace App\Http\Controllers\Admin\Budvar;

use App\Common\BudvarApi;
use App\DataTables\BudvarSliderDataTable;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Budvar\Brand;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SliderController extends AdminController
{

    public function index(BudvarSliderDataTable $dataTable)
    {
        return $dataTable->render('admin.budvar.slider.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { 
        $data = ['type'=>'BANNER']; 
        return view('admin.budvar.slider.item', ['isAction' => 'create', 'item' => $data]);
    }

    protected function storeImage(FormRequest $request)
    {
        $file_str = $request->file('thumb')->store('public/budvar/slider');
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
            'code' => $request->get('code'),
            'lang' => $request->get('lang'),
            'name' => $request->get('name'),
            'type' => $request->get('type'),
            'textButton' => $request->get('textButton'),
        ];
        $response = BudvarApi::postMultipartFile('/brand/create', $json, $request->file('thumb'));
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Thêm thông tin Slider thành công');
            }
            return redirect()->route('admin.budvar.slider.index')->with('success', 'Thêm thông tin Slider thành công');
        }
        return redirect()->back()->withInput()->withErrors(['message' => $response->message ?? 'Có lỗi trong quá trình xử lý!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = BudvarApi::get('/brand/findOne/' . $id);
        $item = $data->data;
        if (empty($item['type'])) $item['type'] = 'BANNER';
        return view('admin.budvar.slider.item', ['isAction' => 'show', 'item' =>  $item]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = BudvarApi::get('/brand/findOne/' . $id);
        $item = $data->data;
        if (empty($item['type'])) $item['type'] = 'BANNER';
        return view('admin.budvar.slider.item', ['isAction' => 'edit', 'item' =>  $item]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormRequest $request, string $id)
    { 
        $json = [
            'code' => $request->get('code'),
            'lang' => $request->get('lang'),
            'name' => $request->get('name'),
            'type' => 'BANNER',
            'textButton' => $request->get('textButton'),
        ];
        $response = BudvarApi::putMultipartFile('/brand/update/' . $id, $json, $request->file('thumb'));
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Chỉnh sửa thông tin Slider thành công');
            }
            return redirect()->route('admin.budvar.slider.index')->with('success', 'Chỉnh sửa thông tin Slider thành công');
        }

        return redirect()->back()->withInput()->withErrors(['message' => 'Có lỗi trong quá trình xử lý!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = BudvarApi::delete('/brand/remove/' . $id);
        if ($response->status == 'success') {
            return response()->json(\App\Common\Response::success());
        }
        return response()->json(\App\Common\Response::error('Có lỗi trong quá trình xử lý!'));
    }
}
