@can('Administrator')
<li class="nav-item pcoded-menu-caption">
    <label>ADMINISTRATOR</label>
</li>
@can('Admin\AccountController@index')
<li class="nav-item "> <a href="{{ route('admin.account.index') }}" class="nav-link "> <span class="pcoded-micon"><i class="feather icon-user-check"></i></span>
        <span class="pcoded-mtext">Tài khoản</span> </a></li>
@endcan
@can('Admin\RoleController@index')
<li class="nav-item "> <a href="{{ route('admin.role.index') }}" class="nav-link "> <span class="pcoded-micon"><i class="feather icon-command"></i></span>
        <span class="pcoded-mtext">Phân quyền</span> </a></li>
@endcan
@can('Admin\PermissionController@index')
<li class="nav-item "> <a href="{{ route('admin.permission.index') }}" class="nav-link "> <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
        <span class="pcoded-mtext">Quyền hệ thống</span> </a></li>
@endcan
@can('Admin\LogsController@index')
<li class="nav-item "> <a href="{{ route('admin.logs.index') }}" class="nav-link "> <span class="pcoded-micon"><i class="feather icon-clipboard"></i></span>
        <span class="pcoded-mtext">Logs</span> </a></li>
@endcan
@endcan

