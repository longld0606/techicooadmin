<?php

namespace App\Http\Controllers\Admin;

use App\Common\Response;
use App\DataTables\RoleDataTable;
use App\Http\Requests\StoreLogsRequest;
use App\Http\Requests\UpdateLogsRequest;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends AdminController
{ 
    /**
     * Display a listing of the resource.
     */

    public function index(RoleDataTable $dataTable)
    {
        //        
        return $dataTable->render('admin.role.index', []);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = new Role();
        $data->guard_name = 'admin';
        return view('admin.role.item', ['isAction' => 'create', 'item' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormRequest $request)
    { 
        if (!empty($request->get('name'))) {
            $exists = Role::query()
                ->where("name", $request->get('name'))
                ->where("guard_name", $request->get('guard_name'))
                ->exists();
            if ($exists) {
                return redirect()->back()->withInput()->withErrors(['message' => 'Dữ liệu trong đã tồn tại']);
            }
        }
        //
        Role::create(['name' =>  $request->get('name'), 'guard_name' =>  $request->get('guard_name')]);
        // if ($data->save()) {
        $ref = $request->get('ref', '');
        if (!empty($ref)) {
            return redirect($ref)->with('success', 'Thêm mới thành công');
        }
        return redirect()->route('admin.role.index')->with('success', 'Thêm mới thành công');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //  
        $allPers = Permission::query()->get()->toArray();
        $role_pers = $role->permissions()->pluck('id')->toArray(); 
        return view('admin.role.edit', ['isAction' => 'edit', 'item' => $role, 'allPers' =>  $allPers, 'role_pers' => $role_pers]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormRequest $request, int $id)
    {
        //   
        $data = Role::query()->where('id', $id)->first();
        if (!$data instanceof Role) {
            return redirect()->back()->withInput()->withErrors(['message' => 'Không tìm thấy dữ liệu']);
        }
        $exists = Role::query()
            ->where("id", "!=", $data->id)
            ->where("name", $request->get('name'))
            ->where("guard_name", $data->guard_name)
            ->exists();
        if ($exists) {
            return redirect()->back()->withInput()->withErrors(['message' => 'Dữ liệu trong đã tồn tại']);
        }
        $data->name =  $request->get('name'); 
        $data->updated_at =  time();
        $data->save();

        $new_pers =  $request->get('pers');

        $permissions = Permission::query()->whereIn('id', $new_pers)->get();
        $data->syncPermissions($permissions);
        
        return redirect()->route('admin.role.index')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {

        $data = Role::query()->where('id', $id)->first();
        if (!$data instanceof Role) {
            return response()->json(Response::error('Không tìm thấy dữ liệu!'));
        }
        // check sử dụng hay k

        // xóa
        $updated = Role::query()->where('id', $id)->delete();
        if ($updated) {
            return response()->json(Response::success());
        }

        return response()->json(Response::error('Có lỗi trong quá trình xử lý!'));
    }
}
