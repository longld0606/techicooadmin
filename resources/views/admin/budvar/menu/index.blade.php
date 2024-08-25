@section('index')
<div class="col-sm-3 mb-3">
    @include('admin.partials._input_select2', [
    'title' => 'Vị trí',
    'array' => ['TOP'=>'TOP','BOTTOM'=>'BOTTOM'],
    'name' => 'location',
    'all_title' => '-- Vị trí --', 
    ])
</div>
<div class="col-sm-3 mb-3">
    @include('admin.partials._input_select2_list', [
    'title' => 'Cấp trên',
    'array' => $menus,
    'name' => 'parent_id',
    'all_title' => '-- Cấp trên --',
    'id_field' => '_id',
    'val_field' => 'name',
    ])
</div>
@endsection
@extends('admin.partials._index', ['lang'=>true])