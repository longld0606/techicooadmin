@can('Admin\AccountController@index')
<li class="nav-item"> <a href="{{ route('admin.account.index') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
        <p>Tài khoản</p>
    </a> </li>
@endcan
@can('Admin\RoleController@index')
<li class="nav-item"> <a href="{{ route('admin.role.index') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
        <p>Phân quyền</p>
    </a> </li>
@endcan
@can('Admin\PermissionController@index')
{{-- <li class="nav-item"> <a href="{{ route('admin.permission.index') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
        <p>Quyền hệ thống</p>
    </a> </li> --}}
@endcan
@can('Admin\LogsController@index')
<li class="nav-item"> <a href="{{ route('admin.logs.index') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
        <p>Logs</p>
    </a> </li>
@endcan