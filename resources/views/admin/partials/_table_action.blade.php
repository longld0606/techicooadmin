<button onclick="search()" type="button" class="btn btn-primary btn-flat">
    {{ __('Tìm kiếm') }}</button>
&nbsp;
<button type="button" onclick="location.href='{{ route($ctrl . '.create') }}'" class="btn btn-success  btn-flat">
    {{ __('Thêm mới') }}</button>
&nbsp;
<div class="btn-group">
    <button type="button" class="btn bg-purple  btn-flat">Xuất file</button>
    <button type="button" class="btn bg-purple btn-flat dropdown-toggle" data-toggle="dropdown">
        <span class="caret"></span>
        <span class="sr-only"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="javascript:void(0)" onclick="onExport('excel')">Xuất file Excel</a></li>
        <li><a href="javascript:void(0)" onclick="onExport('csv')">Xuất file CSV</a></li>
        <li><a href="javascript:void(0)" onclick="onExport('print')">In - Print</a></li>
    </ul>
</div>
