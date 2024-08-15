<?php

namespace App\Http\Controllers\Admin\Budvar;

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
        $data = new Contact();
        return view('admin.budvar.page.item', ['isAction' => 'create', 'item' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormRequest $request)
    {
        //
        $data = new Contact();
        if (!empty($request->get('orderby')))
            $data->orderby = $request->get('orderby');
        $user = Auth::user();
        
        $data->created_at = time();
        $data->created_id = $user->id;

        if ($data->save()) {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Thêm mới mô tả dự án thành công');
            }
            return redirect('admin.budvar.page')->with('success', 'Thêm mới mô tả dự án thành công');
        }
        return redirect()->back()->withInput()->withErrors(['message' => 'Có lỗi xảy ra']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $page)
    {
        //     
        return view('admin.budvar.page.item', ['isAction' => 'show', 'item' => $page]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $page)
    {
        //     
        return view('admin.budvar.page.item', ['isAction' => 'edit', 'item' => $page]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormRequest $request, int $id)
    {
        //
        //
        $data = Contact::query()->where('id', $id)->first();
        $user = Auth::user();

        $data->updated_at = time();
        $data->updated_id = $user->id;

        if ($data->save()) {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Chỉnh sửa thông tin mô tả dự án thành công');
            }

            return redirect('admin.budvar.page')->with('success', 'Chỉnh sửa thông tin mô tả dự án thành công');
        }


        return redirect()->back()->withInput()->withErrors(['message' => 'Có lỗi xảy ra']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $data = Contact::query()->where('id', $id)->first();
        if (!$data instanceof Contact) {
            return \App\Common\Response::error('Không tìm thấy dữ liệu!');
        }
        $updated = Contact::query()->where('id', $id)->delete();
        if ($updated) {
            return \App\Common\Response::success();
        }

        return \App\Common\Response::error('Có lỗi trong quá trình xử lý!');
    }
}
