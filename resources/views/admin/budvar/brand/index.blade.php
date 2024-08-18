<?php
$ctrl = 'admin.budvar.brand';
$nav = ['BUDVAR' => route('admin.budvar.dashboard'), 'BRAND' => route($ctrl.'.index')];
?>

@section('title', 'Brand')
@extends('admin.layouts.app')

@section('content')

<section class="app-content ">
    @include('admin.partials._alerts')


    <div class="card card-secondary  mb-4 mt-4 search-box">
        @include('admin.partials._card_title')
        <!-- /.box-header -->
        <div class="card-body">
            <div class="row">

                <div class="col-sm-12 mb-3">
                    <div class="form-group">
                        <label for="search">{{ __('Tìm kiếm') }}</label>
                        <input type="text" class="form-control" name="search" autocomplete="search" placeholder="Từ khóa">
                    </div> 
                </div>
                <div class="col-sm-12 mb-3"> 
                    @include('admin.partials._input_select2', [
                        'title' => 'Loại',
                        'name' => 'type',
                        'array' => ['' => '--- Loại ---','BRAND' => 'BRAND', 'BANNER' => 'BANNER'], 
                    ])
                </div>

                @include('admin.partials._search_button',[])

            </div>
        </div>
        <!-- /.box-body -->
    </div>


    <div class="card card-secondary card-outline mb-4 mt-4 table-box">

        <!-- /.box-header -->
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
        <!-- /.box-body -->
    </div>

</section>
<!-- /.content -->
@endsection
@push('scripts')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush