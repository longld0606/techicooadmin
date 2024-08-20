<?php

namespace App\Http\Controllers\Admin\Budvar;

use App\Common\BudvarApi;
use App\DataTables\BudvarPostDataTable;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Budvar\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PostController extends AdminController
{

    public function index(BudvarPostDataTable $dataTable)
    {
        return $dataTable->render('admin.budvar.post.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = ['type' => 'post'];
        return view('admin.budvar.post.item', ['isAction' => 'create', 'item' => $data]);
    }

    protected function storeImage(FormRequest $request)
    {
        // $path = $request->file('thumb')->store('public/budvar/post');
        // return substr($path, strlen('public/budvar'));
        $file_str = $request->file('thumb')->store('public/budvar/post');
        $path = substr($file_str, strlen('public/'));
        //$link = asset('storage/'. $path);
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
            'short' => $request->get('short'),
            'content' => $request->get('content'),
            'type' => 'POST',
            'category' => '66ab4ba3b91c0ecad3492094'
        ];
        $response = BudvarApi::postMultipartFile('/post/create', $json, $request->file('thumb'));
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Thêm thông tin Post thành công');
            }
            return redirect('admin.budvar.post.index')->with('success', 'Thêm thông tin Post thành công');
        }
        return redirect()->back()->withInput()->withErrors(['message' => $response->message ?? 'Có lỗi trong quá trình xử lý!']);
    }

    public function clone(string $id)
    {
        $data = BudvarApi::get('/post/findOne/' . $id);
        $item = $data->data;
        if (empty($item['type'])) $item['type'] = 'post';
        return view('admin.budvar.post.item', ['isAction' => 'create', 'item' => $item]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = BudvarApi::get('/post/findOne/' . $id);
        $item = $data->data;
        if (empty($item['type'])) $item['type'] = 'post';
        return view('admin.budvar.post.item', ['isAction' => 'show', 'item' =>  $item]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = BudvarApi::get('/post/findOne/' . $id);
        $item = $data->data;
        if (empty($item['type'])) $item['type'] = 'post';
        return view('admin.budvar.post.item', ['isAction' => 'edit', 'item' =>  $item]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormRequest $request, string $id)
    {
        $json = [
            'title' => $request->get('title'),
            'lang' => $request->get('lang'),
            'short' => $request->get('short'),
            'content' => $request->get('content'),
            'type' => 'POST',
            'category' => '66ab4ba3b91c0ecad3492094'
        ];

        $response = BudvarApi::putMultipartFile('/post/update/' . $id, $json, $request->file('thumb'));
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Chỉnh sửa thông tin Post thành công');
            }
            return redirect('admin.budvar.post.index')->with('success', 'Chỉnh sửa thông tin Post thành công');
        }

        return redirect()->back()->withInput()->withErrors(['message' => 'Có lỗi trong quá trình xử lý!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = BudvarApi::delete('/post/remove/' . $id);
        if ($response->status == 'success') {
            return response()->json(\App\Common\Response::success());
        }
        return response()->json(\App\Common\Response::error('Có lỗi trong quá trình xử lý!'));
    }
}
