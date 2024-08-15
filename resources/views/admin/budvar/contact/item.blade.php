@extends('admin.layouts.app')
<?php
$ctrl = 'admin.budvar.page';
$url = '';
$title = 'Thông tin PAGE';
$btn = '';
$isDisabled = true;
if ($isAction == 'create') {
    $title = 'Thêm mới PAGE';
    $url = route($ctrl . '.store');
    $isDisabled = false;
    $btn = 'Lưu';
} elseif ($isAction == 'edit') {
    $title = 'Chỉnh sửa PAGE';
    $url = route($ctrl . '.update', $item->id);
    $isDisabled = false;
    $btn = 'Cập nhật';
} elseif ($isAction == 'show') {
    $title = 'Xem thông tin PAGE';
    $url = '';
    $isDisabled = true;
}

$nav = ['BUDVAR' => route('admin.budvar.dashboard'), 'PAGE' => route($ctrl.'.index'), $title => '#'];

$isDisabled = true;
?>


@section('title', 'Tài khoản')
@section('content')

<section class="app-content ">
    @include('admin.partials._alerts')

    <div class="card card-secondary  mb-4 mt-4 search-box">
        @include('admin.partials._card_title', ['title' => $title])
        <!-- /.box-header -->
        <div class="card-body">
            <?php $ref = request()->get('ref', '') != '' ? request()->get('ref') : route( $ctrl . '.index'); ?>
            <input type="hidden" name="ref" value="{{ $ref }}" />
        </div>
        @include('admin.partials._save_button')
    </div>
</section>
<!-- /.content -->
@endsection

@push('scripts')

@endpush