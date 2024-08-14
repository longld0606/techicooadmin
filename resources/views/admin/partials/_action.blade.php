<div class="btn-group">
    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="caret"></span>
        <span class="sr-only"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        {{-- <li><a class="dropdown-item"
                href="{{ route('admin.'.$table.'.show', $id) }}"> <i
                    class="fa fa-info-circle"></i> Xem</a></li> --}}
        <li><a class="dropdown-item"
                href="/admin/{{ isset($sub) ? $sub . '/' : '' }}{{ $table }}/{{ $id }}"> <i
                    class="fa fa-fw fa-info-circle"></i> Xem</a></li>
        <li><a class="dropdown-item"
                href="/admin/{{ isset($sub) ? $sub . '/' : '' }}{{ $table }}/{{ $id }}/edit"> <i
                    class="fa fa-fw fa-edit"></i> Chỉnh sửa</a></li>

        <li class="dropdown-divider"> </li>
        <li>
            <a class="dropdown-item delete-item" title="Xóa" href="javascript:void(0);"
                data-href="/admin/{{ isset($sub) ? $sub . '/' : '' }}{{ $table }}/{{ $id }}"
                data-id={{ $id }}>
                <i class="fa fa-fw fa-trash-o"></i> Xóa
            </a>
        </li>
    </ul>
</div>
