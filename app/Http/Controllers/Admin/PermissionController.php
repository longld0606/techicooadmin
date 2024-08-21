<?php

namespace App\Http\Controllers\Admin;

use App\Common\Enum_ControllerActionName;
use App\Common\Response;
use App\DataTables\PermissionDataTable;
use App\Http\Requests\StoreLogsRequest;
use App\Http\Requests\UpdateLogsRequest;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends AdminController
{
    /**
     * Display a listing of the resource.
     */

    public function index(PermissionDataTable $dataTable)
    {
        //        
        return $dataTable->render('admin.permission.index', []);
    }

    function getControllersName()
    {
        $controllers = [];
        $routers = Route::getRoutes()->getRoutes();
        foreach ($routers as $route) {
            $action = $route->getAction();

            if (array_key_exists('controller', $action)) {
                // You can also use explode('@', $action['controller']); here
                // to separate the class name from the method
                $act =  $action['controller'];
                if (
                    str_starts_with($act, "App\Http\Controllers\Admin")
                    && !str_contains($act, "PermissionController")
                    && !str_contains($act, "Admin\DashboardController")
                    && !str_contains($act, "LoginController")
                )
                    $controllers[] = $action['controller'];
            }
        }
        return $controllers;
    }

    public function updatePermissionByName($user, $name)
    {
        if (empty($name)) return \App\Common\Response::error();
        $data = Permission::query()->where('name', $name)->first();
        if (!$data instanceof Permission) {
            $data = new Permission();
            $data->created_at = time();
        } else {
            $data->updated_at = time();
        }
        $data->name = $name;
        $data->title = $name;
        $data->guard_name = 'admin';
        $data->controller = $name;
        $data->action = $name;
        if (!$data->save())
            return Response::error();
        return Response::success();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function generator(FormRequest $request)
    {
        // 
        $user = Auth::user();
        $controllers = $this->getControllersName();

        $this->updatePermissionByName($user, 'Budvar');
        $this->updatePermissionByName($user, 'Techicoo');
        $this->updatePermissionByName($user, 'Administrator');

        foreach ($controllers as $ctrl) {

            $name = str_replace(['App\Http\Controllers\\'], "", $ctrl);
            $arr = explode("@", $name);
            $data = Permission::query()->where('name', $name)->first();
            if (!$data instanceof Permission) {
                $data = new Permission();
                $data->created_at = time();
            } else {
                $data->updated_at = time();
            }
            $data->name = $name;
            $data->title = $name;
            $data->guard_name = 'admin';
            $data->controller =  $arr[0];
            $data->action = $arr[1];
            if (!$data->save()) {
                return response()->json(Response::error('Có lỗi trong quá trình xử lý!'));
            }
        }
        return response()->json(Response::success());
    }

    public function destroy(int $id)
    {
        $data = Permission::query()->where('id', $id)->first();
        if (!$data instanceof Permission) {
            return response()->json(Response::error('Không tìm thấy dữ liệu!'));
        }
        $exists =   $data->roles()->exists();
        if ($exists) {
            return response()->json(Response::error('Không thể xóa quyền đang được sử dụng!'));
        }
        $updated = Permission::query()->where('id', $id)->delete();
        if ($updated) {
            return response()->json(Response::success());
        }
        return response()->json(Response::error('Có lỗi trong quá trình xử lý!'));
    }
}
