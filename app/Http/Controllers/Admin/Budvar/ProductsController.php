<?php

namespace App\Http\Controllers\Admin\Budvar;

use App\Common\BudvarApi;
use App\DataTables\BudvarProductsDataTable;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Foundation\Http\FormRequest;

class ProductsController extends AdminController
{

    public function index(BudvarProductsDataTable $dataTable)
    {
        $categories = BudvarApi::get('/category/findAll', ['type' => 'product']);
        return $dataTable->render('admin.budvar.products.index', ['categories' => $categories->data]);
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
        return view('admin.budvar.products.item', ['isAction' => 'create', 'item' => $data, 'categories' => $categories->data]);
    }

    public function clone(string $id)
    {
        $data = BudvarApi::get('/products/findOne/' . $id);
        $item = $data->data;
        $item['category'] = $data->data['category']['_id'];
        $categories = BudvarApi::get('/category/findAll', ['type' => 'product']);
        return view('admin.budvar.products.item', ['isAction' => 'create', 'item' => $item, 'categories' => $categories->data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormRequest $request)
    {
        //  
        $json = [
            'name' => $request->get('name'),
            'lang' => $request->get('lang'),
            'mixed' => $request->get('mixed'),
            'description' => $request->get('description'),
            'files' =>  $request->file('thumbs'),
            'icons' =>  $request->file('icons'),
        ];
        $json['details'] = [];
        if (!empty($request->file('icons'))) {
            foreach ($request->file('icons') as $i => $file) { 
                $json['details'][$i] = json_encode(['name' => $i . '1', 'mixed' => $i . '1']);
            }
        } 
 
        $response =  BudvarApi::postMultipart('/products/create', $json); 

        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Thêm thông tin Products thành công');
            }
            return redirect()->route('admin.budvar.products.index')->with('success', 'Thêm thông tin Products thành công');
        }
        return redirect()->back()->withInput()->withErrors(['message' => $response->message ?? 'Có lỗi trong quá trình xử lý!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = BudvarApi::get('/products/findOne/' . $id);
        $item = $data->data;
        $categories = BudvarApi::get('/category/findAll', ['type' => 'product']);
        if (!empty($item['category'])) $item['category'] =  $item['category']['_id'];
        return view('admin.budvar.products.item', ['isAction' => 'show', 'item' =>  $item, 'categories' => $categories->data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = BudvarApi::get('/products/findOne/' . $id);
        $categories = BudvarApi::get('/category/findAll', ['type' => 'product']);
        $item = $data->data;
        if (!empty($item['category'])) $item['category'] =  $item['category']['_id'];
        return view('admin.budvar.products.item', ['isAction' => 'edit', 'item' =>  $item, 'categories' => $categories->data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormRequest $request, string $id)
    {
        $json = [
            'name' => $request->get('name'),
            'lang' => $request->get('lang'),
            'category' => $request->get('category'),
            'short' => $request->get('short'),
            'content' => $request->get('description'),
            'description' => $request->get('description'),
            'price' => 1,
            'discount' => 1
        ];

        $response = BudvarApi::putMultipartFile('/products/update/' . $id, $json, $request->file('thumb'));
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Chỉnh sửa thông tin Products thành công');
            }
            return redirect()->route('admin.budvar.products.index')->with('success', 'Chỉnh sửa thông tin Products thành công');
        }

        return redirect()->back()->withInput()->withErrors(['message' => 'Có lỗi trong quá trình xử lý!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = BudvarApi::delete('/products/remove/' . $id);
        if ($response->status == 'success') {
            return response()->json(\App\Common\Response::success());
        }
        return response()->json(\App\Common\Response::error('Có lỗi trong quá trình xử lý!'));
    }
}
