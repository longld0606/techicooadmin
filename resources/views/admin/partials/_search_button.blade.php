<div class="col-sm-12 mb-3">

    <button onclick="searchTable()" type="button" class="btn btn-primary">
        {{ __('Tìm kiếm') }}</button>
    &nbsp;
    @if( !( isset($isCreate) && $isCreate == false) )
    <button type="button" onclick="location.href='{{ route( $ctrl . '.create') }}'" class="btn btn-success "> {{ __('Thêm mới') }}</button>
    &nbsp;
    @endif

    <div class="btn-group" role="group">
        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            Xuất file
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="javascript:void(0)" onclick="onExport('excel')">Xuất file
                    Excel</a></li>
            <li><a class="dropdown-item" href="javascript:void(0)" onclick="onExport('csv')">Xuất file
                    CSV</a></li>
            <li><a class="dropdown-item" href="javascript:void(0)" onclick="onExport('print')">In - Print</a></li>
        </ul>
    </div>

</div>