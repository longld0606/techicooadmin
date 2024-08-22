@section('index') 
<div class="col-sm-3 mb-3">
    @include('admin.partials._input_select2', [
        'title' => 'Loại',
        'array' => \App\Common\Enum_PageType::getArray(),
        'name' => 'type', 
        'all_title' => '-- Loại --'
    ])
 </div>
@endsection
@push('script')
@endpush
@extends('admin.partials._index', ['lang'=>true])