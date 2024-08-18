<?php

namespace App\Http\Controllers\Admin\Budvar;

use App\Common\BudvarApi;
use App\DataTables\BudvarMediaDataTable;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Budvar\Media;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MediaController extends AdminController
{

    public function index(BudvarMediaDataTable $dataTable)
    {
        return $dataTable->render('admin.budvar.media.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = new Media();
        return view('admin.budvar.media.item', ['isAction' => 'create', 'item' => $data]);
    }

    protected function storeImage(FormRequest $request)
    {
        $file_str = $request->file('thumb')->store('public/budvar/media');
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
            'name' => $request->get('name'),
            'type' => $request->get('type'),
            'textButton' => $request->get('textButton'), 
        ];      
        $response = BudvarApi::postMultipartFile('/media/create', $json, $request->file('thumb'));
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Thêm thông tin Media thành công');
            }
            return redirect('admin.budvar.media.index')->with('success', 'Thêm thông tin Media thành công');
        }
        return redirect()->back()->withInput()->withErrors(['message' => $response->message ?? 'Có lỗi trong quá trình xử lý!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = BudvarApi::get('/media/findOne/' . $id);
        $item = $data->data;
        if (empty($item['type'])) $item['type'] = 'media';
        return view('admin.budvar.media.item', ['isAction' => 'show', 'item' =>  $item]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = BudvarApi::get('/media/findOne/' . $id);
        $item = $data->data;
        if (empty($item['type'])) $item['type'] = 'media';
        return view('admin.budvar.media.item', ['isAction' => 'edit', 'item' =>  $item]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormRequest $request, string $id)
    {
        $user = Auth::user();
        $json = [
            'code' => $request->get('code'),
            'name' => $request->get('name'),
            'type' => $request->get('type'),
            'textButton' => $request->get('textButton'), 
        ];           
        $response = BudvarApi::putMultipartFile('/media/update/' . $id, $json, $request->file('thumb'));
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Chỉnh sửa thông tin Media thành công');
            }
            return redirect('admin.budvar.media.index')->with('success', 'Chỉnh sửa thông tin Media thành công');
        }

        return redirect()->back()->withInput()->withErrors(['message' => 'Có lỗi trong quá trình xử lý!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = BudvarApi::delete('/media/remove/' . $id);
        if ($response->status == 'success') {
            return \App\Common\Response::success();
        }
        return \App\Common\Response::error('Có lỗi trong quá trình xử lý!');
    }
}
