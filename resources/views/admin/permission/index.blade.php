@extends('admin.layouts.app')
@section('content')

<section class="app-content ">
    @include('admin.partials._alerts') 

    <div class="card card-secondary card-outline  mb-4 mt-4 search-box">
        <!-- /.box-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 mb-3">
                    <div class="form-group">
                        <label for="search">{{ __('Tìm kiếm') }}</label>
                        <input type="text" class="form-control" name="search" autocomplete="search" placeholder="Từ khóa">
                    </div>
                </div>

                <div class="col-sm-12 ">
                    <button onclick="searchTable()" type="button" class="btn btn-primary">
                        {{ __('Tìm kiếm') }}</button>
                    &nbsp;
                    {{-- @can('Admin\PermissionController@generator') --}}
                    <button class="confirm-action btn btn-success btn-flat" type="button" title="Generator" href="javascript:void(0);" data-href="{{ route('admin.permission.generator') }}" data-msg="{{ 'Bạn chắc chắn muốn tạo permissions ' }}" data-id={{ 0 }}>
                        <i class="fa fa-database"></i>{{ __('Generator') }}
                    </button>
                    &nbsp;
                    {{-- @endcan --}}
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