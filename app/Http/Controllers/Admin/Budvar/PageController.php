<?php

namespace App\Http\Controllers\Admin\Budvar;

use App\Common\BudvarApi;
use App\DataTables\BudvarPageDataTable;
use App\Http\Controllers\Admin\AdminController;

use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        $data = ['type' => "PAGE"];
        return view('admin.budvar.page.item', ['isAction' => 'create', 'item' => $data]);
    }

    public function clone(string $id)
    {
        $data = BudvarApi::get('/page/findOne/' . $id);
        return view('admin.budvar.page.item', ['isAction' => 'create', 'item' => $data->data]);
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
            
            //'startDate' => $request->get('startDate'),
            //'endDate' => $request->get('endDate'),
            'voucher_limit' => $request->get('voucher_limit'),
            'descriptionVoucher' => $request->get('descriptionVoucher'),

            'short' => $request->get('short'),
            'sections' =>  $request->get('sections'),
            'files' =>  $request->file('thumbs')
        ];
        if(!empty($request->get('startDate')))
            $json['startDate'] = Carbon::createFromFormat('d/m/Y',$request->get('startDate'))->format('Y-m-d');
        if(!empty($request->get('endDate')))
            $json['endDate'] = Carbon::createFromFormat('d/m/Y',$request->get('endDate'))->format('Y-m-d');


        $response =  BudvarApi::postMultipart('/page/create', $json);
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Thêm mới mô tả dự án thành công');
            }
            return redirect()->route('admin.budvar.page.index')->with('success', 'Thêm mới mô tả dự án thành công');
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
            'lang' => $request->get('lang'),
            'type' => $request->get('type'),

            //'startDate' => $request->get('startDate'),
            //'endDate' => $request->get('endDate'),
            'voucher_limit' => $request->get('voucher_limit'),
            'descriptionVoucher' => $request->get('descriptionVoucher'),

            'short' => $request->get('short'),
            'sections' =>  $request->get('sections'),
            'mediasRemove' =>  $request->get('mediasRemove'),
            'files' =>  $request->file('thumbs')
        ];
        if(!empty($request->get('startDate')))
            $json['startDate'] = Carbon::createFromFormat('d/m/Y',$request->get('startDate'))->format('Y-m-d');
        if(!empty($request->get('endDate')))
            $json['endDate'] = Carbon::createFromFormat('d/m/Y',$request->get('endDate'))->format('Y-m-d');

        $response = BudvarApi::putMultipart('/page/update/' . $id, $json);
        if ($response->status == 'success') {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Chỉnh sửa thông tin Page thành công');
            }
            return redirect()->route('admin.budvar.page.index')->with('success', 'Chỉnh sửa thông tin Page thành công');
        }

        return redirect()->back()->withInput()->withErrors(['message' => 'Có lỗi '.(empty($response->message) ? '' : $response->message).'!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = BudvarApi::delete('/page/remove/' . $id);
        if ($response->status == 'success') {
            return response()->json(\App\Common\Response::success());
        }
        return response()->json(\App\Common\Response::error('Có lỗi trong quá trình xử lý!'));
    }
}
