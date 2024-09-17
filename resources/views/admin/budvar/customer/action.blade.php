{{-- @include('admin.partials._action', ['ctrl' => $ctrl, 'id' => $_id, 'confirm'=>true]) --}}

<div class="btn-group">
    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="caret"></span>
        <span class="sr-only"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a class="dropdown-item" href="{{ route($ctrl . '.show', $_id) }}"> <i class="fa fa-fw fa-info-circle"></i>
                Xem</a></li>
        <li><a class="dropdown-item" href="{{ route($ctrl . '.edit', $_id) }}"> <i class="fa fa-fw fa-edit"></i>
                Chỉnh
                sửa</a></li>
        @if(!isset($authenticated) || $authenticated != true)
        <li><a class="dropdown-item confirm-action" href="javascript:void(0);" data-href="{{ route($ctrl . '.authenticated', $_id) }}" data-msg="{{ 'Bạn chắc chắn muốn xác thực tài khoản này?' }}" data-id={{ $_id }}>
            <i class="fa fa-fw fa-check"></i>
                Xác thực</a></li>
        @endif
        <li class="dropdown-divider"> </li>
        @if(!isset($authenticated) || $authenticated != true)
        <li>
            <a class="dropdown-item delete-item" title="Xóa" href="javascript:void(0);" data-href="{{ route($ctrl . '.destroy', $_id) }}" data-id={{ $_id }}>
                <i class="fa fa-fw fa-trash-o"></i> Từ chối xác nhận
            </a>
        </li>
        @else
        <li>
            <a class="dropdown-item delete-item" title="Xóa" href="javascript:void(0);" data-href="{{ route($ctrl . '.destroy', $_id) }}" data-id={{ $_id }}>
                <i class="fa fa-fw fa-trash-o"></i> Xóa
            </a>
        </li>
        @endif
    </ul>
</div>
