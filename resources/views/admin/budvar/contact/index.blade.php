@section('index')
<div class="col-sm-3 mb-3">
    @include('admin.partials._input_select2', [
    'title' => 'Loại',
    'name' => 'type',
    'array' => ['' => '--- Loại ---','contact' => 'Liên hệ', 'order'=>'Đặt hàng', 'event'=>'Sự kiện'],
    ])
</div>
@endsection
@extends('admin.partials._index', ['lang'=>false])