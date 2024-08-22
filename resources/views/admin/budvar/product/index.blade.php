@section('index') 
<div class="col-sm-3 mb-3">
    @include('admin.partials._input_select2_list', [
    'title' => 'Danh mục',
    'array' => $categories,
    'name' => 'category',
    'all_title' => '-- Danh mục sản phẩm --',
    'id_field' => '_id',
    'val_field' => 'title',
    ])
</div>
@endsection
@push('script')
@endpush
@extends('admin.partials._index', ['lang'=>true])