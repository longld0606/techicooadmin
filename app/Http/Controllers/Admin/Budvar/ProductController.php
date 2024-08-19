<?php

namespace App\Http\Controllers\Admin\Budvar;

use App\Common\BudvarApi;
use App\DataTables\BudvarProductDataTable;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Budvar\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductController extends AdminController
{

    public function index(BudvarProductDataTable $dataTable)
    {
        return $dataTable->render('admin.budvar.product.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'name' => ''
        ];
        $categories = BudvarApi::get('/category/findAll', ['type' => 'product']);
        return view('admin.budvar.product.item', ['isAction' => 'create', 'item' => $data, 'categories' => $categories->data]);
    }

    protected function storeImage(FormRequest $request)
    {
        // $path = $request->file('thumb')->store('public/budvar/product');
        // return substr($path, strlen('public/budvar'));
        $file_str = $request->file('thumb')->store('public/budvar/product');
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
            'name' => $request->get('name'),
            'category' => $request->get('category'),
            'short' => $request->get('short'),
            'content' => $request->get('description'),
            'description' => $request->get('description'),
            'price' => 1,
            'discount' => 1
        ];

        $response = BudvarApi::postMultipartFile('/product/create', $json, $request->file('thumb'));
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Thêm thông tin Product thành công');
            }
            return redirect('admin.budvar.product.index')->with('success', 'Thêm thông tin Product thành công');
        }
        return redirect()->back()->withInput()->withErrors(['message' => $response->message ?? 'Có lỗi trong quá trình xử lý!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = BudvarApi::get('/product/findOne/' . $id);
        $item = $data->data;
        $categories = BudvarApi::get('/category/findAll', ['type' => 'product']);
        if (!empty($item['category'])) $item['category'] =  $item['category']['_id'];
        return view('admin.budvar.product.item', ['isAction' => 'show', 'item' =>  $item, 'categories' => $categories->data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = BudvarApi::get('/product/findOne/' . $id);
        $categories = BudvarApi::get('/category/findAll', ['type' => 'product']);
        $item = $data->data;
        if (!empty($item['category'])) $item['category'] =  $item['category']['_id'];
        return view('admin.budvar.product.item', ['isAction' => 'edit', 'item' =>  $item, 'categories' => $categories->data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormRequest $request, string $id)
    {
        $json = [
            'name' => $request->get('name'),
            'category' => $request->get('category'),
            'short' => $request->get('short'),
            'content' => $request->get('description'),
            'description' => $request->get('description'),
            'price' => 1,
            'discount' => 1
        ];

        $response = BudvarApi::putMultipartFile('/product/update/' . $id, $json, $request->file('thumb'));
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Chỉnh sửa thông tin Product thành công');
            }
            return redirect('admin.budvar.product.index')->with('success', 'Chỉnh sửa thông tin Product thành công');
        }

        return redirect()->back()->withInput()->withErrors(['message' => 'Có lỗi trong quá trình xử lý!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = BudvarApi::delete('/product/remove/' . $id);
        if ($response->status == 'success') {
            return response()->json(\App\Common\Response::success());
        }
        return response()->json(\App\Common\Response::error('Có lỗi trong quá trình xử lý!'));
    }
}
