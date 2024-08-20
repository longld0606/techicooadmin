@extends('layouts.app')

<?php
$table = 'role';
$url = '';
$title = '';
$btn = '';
$isDisabled = true;
if ($isAction == 'create') {
    $title = 'Thêm mới';
    $url = route($table . '.store');
    $isDisabled = false;
    $btn = 'Lưu';
} elseif ($isAction == 'edit') {
    $title = 'Chỉnh sửa thông tin';
    $url = route($table . '.update', $item->id);
    $isDisabled = false;
    $btn = 'Cập nhật';
} elseif ($isAction == 'show') {
    $title = 'Xem thông tin';
    $url = '';
    $isDisabled = true;
}
?>

@section('title', $title)
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">
                            {{ $title }}
                        </h3>
                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            @include('partials.alerts')
                            <form class="form-item" method="POST" action="{{ $url }}">
                                @if ($isAction == 'edit')
                                    <input name="_method" type="hidden" value="PUT">
                                @endif
                                @csrf
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name">{{ __('Name') }}</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name', $item->name) }}" required
                                            {{ $isDisabled ? 'disabled' : '' }} />
                                    </div>
                                </div>                                 
                                <div class="col-sm-6" >
                                    <div class="form-group">
                                        <label for="guard_name">{{ __('Guard Name') }}</label>
                                        <input type="text" class="form-control" id="guard_name" name="guard_name"
                                            value="{{ old('guard_name', $item->guard_name) }}" required
                                            {{ $isDisabled ? 'disabled' : '' }} />
                                    </div>
                                </div> 

                                <?php $ref = request()->get('ref', '') != '' ? request()->get('ref') : route($table . '.index'); ?>
                                <input type="hidden" name="ref" value="{{ $ref }}" />
                                <div class="col-sm-12 ">

                                    <div class="pull-right">
                                        <a href="{{ $ref }}">
                                            <button class="btn btn-default btn-flat" type="button"><i
                                                    class="fa fa-chevron-left"></i> &nbsp; Quay lại </button>
                                        </a>
                                        &nbsp;
                                        @if (!$isDisabled)
                                            <button type="submit" class="btn btn-primary btn-flat">
                                                <i class="fa fa-save"></i> &nbsp;
                                                {{ __($btn) }}</button>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
@push('scripts')
@endpush
