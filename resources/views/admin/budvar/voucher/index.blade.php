@extends('admin.partials._index', ['lang' => false, 'isButton' => false])
@section('button')
<div class="col-sm-12 ">
    <button onclick="searchTable()" type="button" class="btn btn-primary">
        {{ __('Tìm kiếm') }}</button>
    &nbsp;
    <button type="button" onclick="location.href='{{ route( $ctrl . '.create') }}'" class="btn btn-success "> {{ __('Thêm mới') }}</button>
</div>
@endsection
