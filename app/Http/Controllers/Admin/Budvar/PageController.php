<?php

namespace App\Http\Controllers\Admin\Budvar;

use App\Common\BudvarApi;
use App\DataTables\BudvarPageDataTable;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Budvar\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PageController extends AdminController
{

    public function index(BudvarPageDataTable $dataTable)
    {
        return $dataTable->render('admin.budvar.page.index', []);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = new Page();
        $data->type = "PAGE";
        return view('admin.budvar.page.item', ['isAction' => 'create', 'item' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormRequest $request)
    {
        //
        $data = new Page();
        $user = Auth::user();


        $data->created_at = time();
        $data->created_id = $user->id;

        if ($data->save()) {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Thêm mới mô tả dự án thành công');
            }
            return redirect('admin.budvar.page.index')->with('success', 'Thêm mới mô tả dự án thành công');
        }
        return redirect()->back()->withInput()->withErrors(['message' => 'Có lỗi xảy ra']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $data = BudvarApi::get('/page/findOne/' . $id);
        return view('admin.budvar.page.item', ['isAction' => 'show', 'item' => $data->data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = BudvarApi::get('/page/findOne/' . $id);
        return view('admin.budvar.page.item', ['isAction' => 'edit', 'item' => $data->data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormRequest $request, string $id)
    {
        $json = [
            'title' => $request->get('title'),
            'type' => $request->get('type'),
            'short' => $request->get('short'),
            'content' => $request->get('content'),
        ];
        $response = BudvarApi::put('/page/update/' . $id, $json);
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Chỉnh sửa thông tin Page thành công');
            }
            return redirect('admin.budvar.page.index')->with('success', 'Chỉnh sửa thông tin Page thành công');
        }

        return redirect()->back()->withInput()->withErrors(['message' => 'Có lỗi trong quá trình xử lý!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = BudvarApi::delete('/page/remove/' . $id);
        if ($response->status == 'success') {
            return \App\Common\Response::success();
        }
        return \App\Common\Response::error('Có lỗi trong quá trình xử lý!');
    }
}
