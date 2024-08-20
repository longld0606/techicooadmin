<?php $router_table = 'admin.role'; ?>
<div class="btn-group">
    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
        <span class="caret"></span>
        <span class="sr-only"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{{ route($router_table . '.edit', $id) }}"> <i class="fa fa-key"></i> Chỉnh sửa - Phân quyền</a></li>
        <li class="divider"></li>
        <li>
            <a class="delete-item" title="Xóa" href="javascript:void(0);"
                data-href="{{ route($router_table . '.destroy', $id) }}" data-id={{ $id }}>
                <i class="fa fa-fw fa-trash-o"></i> Xóa
            </a>
        </li>
    </ul>
</div>

