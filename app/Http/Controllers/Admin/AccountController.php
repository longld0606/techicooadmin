<?php

namespace App\Http\Controllers\Admin;

use App\Common\BudvarApi;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use  App\Common\Response;
use App\DataTables\AccountDataTable;
use App\Models\UserConfig;

class AccountController extends AdminController
{

    /**
     * Display a listing of the resource.
     */
    public function index(AccountDataTable $dataTable)
    {
        return $dataTable->render('admin.account.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = new User();
        $data->status = \App\Common\Enum_STATUS::ACTIVE;
        return view('admin.account.item', ['isAction' => 'create', 'item' => $data]);
    }



    protected function storeAvatar(FormRequest $request)
    {
        $file_str = $request->file('avatar')->store('public/avatar');
        $path = substr($file_str, strlen('public/'));
        $link = asset('storage/' . $path);
        return $link . '';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\App\Http\Requests\StoreUserRequest $request)
    {
        //
        $user = Auth::user();
        $data = new \App\Models\User();
        $data->name = $request->get('name');
        $data->email = $request->get('email');
        $data->phone = $request->get('phone');

        if ($request->get('password') != $request->get('password_confirmation')) {
            return redirect()->back()->withInput()->withErrors(['message' => 'Mật khẩu không chính xác!']);
        }
        $exists = User::query()
            ->where("name", $data->name)
            ->exists();
        if ($exists) {
            return redirect()->back()->withInput()->withErrors(['message' => 'Tên người dùng đã tồn tại!']);
        }
        $exists = User::query()
            ->where("email", $data->email)
            ->exists();
        if ($exists) {
            return redirect()->back()->withInput()->withErrors(['message' => 'Email người dùng đã tồn tại!']);
        }
        $exists = User::query()
            ->where("phone", $data->phone)
            ->exists();
        if ($exists) {
            return redirect()->back()->withInput()->withErrors(['message' => 'SĐT người dùng đã tồn tại!']);
        }
        if ($request->file('avatar'))
            $data->avatar = $this->storeAvatar($request);
        $data->password = bcrypt($request->get('password'));

        $data->type = $request->get('type');
        $data->status = $request->get('status');
        $data->gender = $request->get('gender');
        $data->birthday = $request->get('birthday');

        $data->created_at = time();
        $data->created_id = $user->id;

        if ($data->save()) {
            UserConfig::query()->where('user_id', $data->id)->delete();
            if (!empty($request->get('isBudvar') && $request->get('isBudvar') == 1)) {
                $cf = new UserConfig();
                $cf->user_id = $data->id;
                $cf->tenant = 'Budvar';
                $cf->username = $data->phone;
                $cf->password = $request->get('password') . 'aZ@9';
                $cf->created_at = time();
                $cf->created_id = $user->id;
                // create budvar
                BudvarApi::post('/user/create', [
                    "phone" => $data->phone,
                    "password" => $cf->password,
                ]);
                $cf->save();
            }
            if (!empty($request->get('isTechicoo')) && $request->get('isTechicoo') == 1) {
                $cf = new UserConfig();
                $cf->user_id = $data->id;
                $cf->tenant = 'Techicoo';
                $cf->username = $data->phone;
                $cf->password = $request->get('password');
                $cf->created_at = time();
                $cf->created_id = $user->id;
                $cf->save();
            }
            if (!empty($request->get('isAdmin')) && $request->get('isAdmin') == 1) {
                $cf = new UserConfig();
                $cf->user_id = $data->id;
                $cf->tenant = 'Administrator';
                $cf->username = $data->phone;
                $cf->password = $request->get('password');
                $cf->created_at = time();
                $cf->created_id = $user->id;
                $cf->save();
            }

  

            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Thêm mới người dùng thành công');
            }
            return redirect('admin.account')->with('success', 'Thêm mới người dùng thành công');
        }
        return redirect()->back()->withInput()->withErrors(['message' => 'Có lỗi xảy ra']);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $account)
    {
        //
        $roles = Role::query()->get()->toArray();
        $user_roles = []; // $account->roles()->pluck('role_id')->toArray();
        $user_configs = $account->configs()->pluck('tenant')->toArray();
        return view('admin.account.item', ['isAction' => 'show', 'item' =>  $account, 'roles' => $roles, 'user_roles' => $user_roles, 'user_configs' => $user_configs]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $account)
    {
        //
        $roles = Role::query()->get()->toArray();
        $user_roles = []; // $account->roles()->pluck('role_id')->toArray();
        $user_configs = $account->configs()->pluck('tenant')->toArray();
        return view('admin.account.item', ['isAction' => 'edit', 'item' =>  $account, 'roles' => $roles, 'user_roles' => $user_roles, 'user_configs' => $user_configs]);
    }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        //
        $data = \App\Models\User::query()->where('id', $id)->first();
        if (!$data instanceof \App\Models\User) {
            abort(404);
        }
        $user = Auth::user();

        $data->name = $request->get('name');
        $data->email = $request->get('email');
        $data->phone = $request->get('phone');

        $exists = \App\Models\User::query()
            ->where("id", '!=', $data->id)
            ->where("name", $data->name)
            ->exists();
        if ($exists) {
            return redirect()->back()->withInput()->withErrors(['message' => 'Tên người dùng đã tồn tại. Để đỡ nhầm lẫn thì dùng tên khác nhé!']);
        }
        $exists = \App\Models\User::query()
            ->where("id", '!=', $data->id)
            ->where("email", $data->email)
            ->exists();
        if ($exists) {
            return redirect()->back()->withInput()->withErrors(['message' => 'Email người dùng đã tồn tại!']);
        }
        $exists = \App\Models\User::query()
            ->where("id", '!=', $data->id)
            ->where("phone", $data->phone)
            ->exists();
        if ($exists) {
            return redirect()->back()->withInput()->withErrors(['message' => 'SĐT người dùng đã tồn tại!']);
        }
        if ($request->file('avatar'))
            $data->avatar = $this->storeAvatar($request);

        $data->type = $request->get('type');
        $data->status = $request->get('status');
        $data->gender = $request->get('status');
        $data->birthday = $request->get('birthday');

        $data->updated_at = time();
        $data->updated_id = $user->id;

        // $roles =  $request->get('roles');
        // if(!empty($roles)){
        //     $arr_roles = Role::query()->whereIn('id', $roles)->get()->pluck('name')->toArray();
        //     $data->syncRoles($arr_roles);
        // }

        if ($data->save()) {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Thêm mới người dùng thành công');
            }
            return redirect('admin.account')->with('success', 'Thêm mới người dùng thành công');
        }


        return redirect()->back()->withInput()->withErrors(['message' => 'Có lỗi xảy ra']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $data = \App\Models\User::query()->where('id', $id)->first();
        if (!$data instanceof \App\Models\User) {
            return Response::error('Không tìm thấy dữ liệu!');
        }
        $updated = \App\Models\User::query()->where('id', $id)->delete();
        if ($updated) {
            return Response::success();
        }
        return Response::error('Có lỗi trong quá trình xử lý!');
    }

    public function setPass(FormRequest $request, int $id) {}

    public function setactive(int $id)
    {
        $user = Auth::user();
        $data = \App\Models\User::query()->where('id', $id)->first();
        if (!$data instanceof \App\Models\User) {
            return Response::error('Không tìm thấy dữ liệu!');
        }
        $data->status = $data->status == \App\Common\Enum_STATUS::ACTIVE ? \App\Common\Enum_STATUS::NOACTIVE : \App\Common\Enum_STATUS::ACTIVE;

        $data->updated_at = time();
        $data->updated_id = $user->id;
        if ($data->save()) {
            return Response::success();
        }
        return Response::error('Có lỗi trong quá trình xử lý!');
    }


    public function setpassword(int $id)
    {
        $data = \App\Models\User::query()->where('id', $id)->first();
        if (!$data instanceof \App\Models\User) {
            abort(404);
        }
        return view('admin.account.setpassword', ['item' =>  $data]);
    }


    public function savepassword(UpdateUserRequest $request, int $id)
    {
        //
        $data = \App\Models\User::query()->where('id', $id)->first();
        if (!$data instanceof \App\Models\User) {
            abort(404);
        }
        $user = Auth::user();
        if ($request->get('password') != $request->get('password_confirmation')) {
            return redirect()->back()->withInput()->withErrors(['message' => 'Mật khẩu không chính xác!']);
        }
        $data->password = bcrypt($request->get('password'));

        $data->updated_at = time();
        $data->updated_id = $user->id;

        if ($data->save()) {
            $ref = $request->get('ref', '');
            if (!empty($ref)) {
                return redirect($ref)->with('success', 'Đặt mật khẩu cho người dùng thành công');
            }
            return redirect('admin.account')->with('success', 'Đặt mật khẩu cho người dùng thành công');
        }

        return redirect()->back()->withInput()->withErrors(['message' => 'Có lỗi xảy ra']);
    }
}
