<div class="btn-group">
    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="caret"></span>
        <span class="sr-only"></span>
    </button>

    <?php 
    $authenticated =  isset($owner) && isset($owner['authenticated']) && $owner['authenticated'];
    $ck = false;// $usageCount > 0 && $usageCount   <= $usageLimit;
?>
    <ul class="dropdown-menu" role="menu">
        <li><a class="dropdown-item" href="{{ route($ctrl . '.show', $_id) }}"> <i class="fa fa-fw fa-info-circle"></i>
                Xem</a></li>
        @if ($ck == false)
        <li><a class="dropdown-item" href="{{ route($ctrl . '.edit', $_id) }}"> <i class="fa fa-fw fa-edit"></i>
                Chỉnh
                sửa</a></li>
        @endif
        @if(isset($authenticated) && $authenticated == true && $ck == false)
        <li><a class="dropdown-item confirm-action" href="javascript:void(0);" data-href="{{ route($ctrl . '.confirm', ['id' => $_id, 'customeId' => $owner['_id'] ] ) }}" data-msg="{{ 'Bạn chắc chắn muốn xác nhận phiếu quà tặng này?' }}" data-id={{ $_id }}>
                <i class="fa fa-fw fa-check"></i>
                Xác nhận Voucher</a></li>
        @endif

        @if ($ck == false)
        <li class="dropdown-divider"> </li>
        <li>
            <a class="dropdown-item delete-item" title="Xóa" href="javascript:void(0);" data-href="{{ route($ctrl . '.destroy', $_id) }}" data-id={{ $_id }}>
                <i class="fa fa-fw fa-trash-o"></i> Xóa
            </a>
        </li>
        @endif
    </ul>
</div>
