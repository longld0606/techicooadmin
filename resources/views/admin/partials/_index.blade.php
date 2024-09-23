@extends('admin.layouts.app')
@section('content')
<?php
    if(!isset($isButton))
    $isButton = true;
?>
<section class="app-content ">
    @include('admin.partials._alerts')
    <div class="card card-secondary card-outline mb-4 mt-4 search-box">
        <div class="card-body">
            <div class="row">
                @include('admin.partials._search_input', ['lang'=> isset($lang) ? $lang : true, 'searchText' =>isset($searchText) ? $searchText : true])
                @if($isButton == true)
                    @include('admin.partials._search_button',['isCreate'=> isset($isCreate) ? $isCreate : true])
                @endif
                @yield('button')
            </div>
        </div>
    </div>
    <div class="card card-secondary card-outline mb-4 mt-4 table-box">
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
</section>
@endsection
@push('scripts')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@stack('script')
@endpush
