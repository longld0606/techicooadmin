 

<?php $ctrl = 'admin.role'; ?>
 
<div class="btn-group">
    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="caret"></span>
        <span class="sr-only"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a class="dropdown-item" title="Chỉnh sửa - Phân quyền"  href="{{ route($ctrl . '.edit', $id) }}"> <i class="fa fa-key"></i> Chỉnh sửa - Phân quyền</a></li>
        <li class="dropdown-divider"> </li>
        <li>
            <a class="dropdown-item delete-item" title="Xóa" href="javascript:void(0);"
                data-href="{{ route($ctrl . '.destroy', $id) }}"
                data-id={{ $id }}>
                <i class="fa fa-fw fa-trash-o"></i> Xóa
            </a>
        </li>
    </ul>
</div>
