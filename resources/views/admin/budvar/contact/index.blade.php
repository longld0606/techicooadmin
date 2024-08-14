<?php
$nav = ['BUDVAR' => route('admin.budvar.dashboard'), 'Contact' => route('admin.budvar.contact')];
$ctrl = 'contact';
?>

@section('title', 'Contact')
@extends('admin.layouts.app')

@section('content')

    <section class="app-content ">
        @include('admin.partials._alerts')


        <div class="card card-secondary  mb-4 mt-4 search-box">
            <div class="card-header">
                <h3 class="card-title">
                    Tìm kiếm
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" title="Collapse">
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse"class="bi bi-dash-lg"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="card-body">
                <div class="row">

                    <div class="col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="search">{{ __('Tìm kiếm') }}</label>
                            <input type="text" class="form-control" name="search" autocomplete="search"
                                placeholder="Từ khóa">
                        </div>
                    </div>

                    <div class="col-sm-12 mb-3">
                        <button onclick="searchTable()" type="button" class="btn btn-primary">
                            {{ __('Tìm kiếm') }}</button>
                        &nbsp;
                        {{-- <button type="button" onclick="location.href='{{ route($ctrl . '.create') }}'"
                            class="btn btn-success  "> {{ __('Thêm mới') }}</button>
                        &nbsp; --}}

                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">
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
                </div>
                <!-- /.box-body -->
            </div>
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
