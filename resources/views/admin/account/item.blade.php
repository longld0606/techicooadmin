@extends('admin.layouts.app')
<?php
$title = 'Thông tin Tài khoản';
$nav = ['Tài khoản' => route('admin.account.index'), $title => '#'];
$ctrl = 'account';
$isDisabled = false;
?>


@section('title', 'Tài khoản')
@section('content')

    <section class="app-content ">
        @include('admin.partials._alerts')

        <div class="card card-secondary  mb-4 mt-4 search-box">
            @include('admin.partials._card_title', ['title' => $title])
            <!-- /.box-header -->
            <div class="card-body">
                <h1>Thông tin</h1>
                <?php $ref = request()->get('ref', '') != '' ? request()->get('ref') : route('admin.' . $ctrl . '.index'); ?>
                <input type="hidden" name="ref" value="{{ $ref }}" />
            </div>
            <div class="card-footer">
                <div class="text-end">
                    <a href="{{ $ref }}" class="btn btn-default btn-flat"> <i class="fa fa-chevron-left"></i> &nbsp;
                        Quay lại </a>
                    @if (!$isDisabled)
                        <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i>
                            &nbsp;{{ 'Lưu' }}</button>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
