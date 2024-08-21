<?php
$ctrl = 'admin.role';
$url = '';
$title = 'Nhóm quyền';
$btn = '';
$isDisabled = true;
if ($isAction == 'create') {
    $title = 'Thêm mới nhóm quyền';
    $url = route($ctrl . '.store');
    $isDisabled = false;
    $btn = 'Lưu';
} elseif ($isAction == 'edit') {
    $title = 'Chỉnh sửa nhóm quyền';
    $url = route($ctrl . '.update', $item['_id']);
    $isDisabled = false;
    $btn = 'Cập nhật';
} elseif ($isAction == 'show') {
    $title = 'Xem thông tin nhóm quyền';
    $url = '';
    $isDisabled = true;
}

$nav = ['BUDVAR' => route('admin.budvar.dashboard'), 'NHÓM QUYỀN' => route($ctrl . '.index'), $title => '#'];
?>

@section('title', $title)
@extends('admin.layouts.app')
@section('content')


<section class="app-content ">

    <div class="card card-secondary  mb-4 mt-4 item-box">
        @include('admin.partials._card_title', ['title' => $title])
        <div class="card-body">

            @include('admin.partials._alerts')

            <form class="form-item" method="POST" action="{{ $url }}" enctype="multipart/form-data">
                @if ($isAction == 'edit')
                <input name="_method" type="hidden" value="PATCH">
                @endif
                <input name="type" type="hidden" value="product">
                @csrf
                <div class="row">
                    <div class="col-sm-6 mb-3"> 
                        @include('admin.partials._input_val', [
                        'title' => 'Tên',
                        'name' => 'name',
                        'val' => old('name',isset($item['name']) ? $item['name'] : ''),
                        'isRequired' => true
                        ])
                    </div> 
                    <div class="col-sm-6 mb-3">
                        @include('admin.partials._input_val', [
                        'title' => 'Tên',
                        'name' => 'guard_name',
                        'val' => old('guard_name',isset($item['guard_name']) ? $item['guard_name'] : ''),
                        'isRequired' => true
                        ])
                    </div>
                </div>
       
                <div class="card-body">
                    <?php $ref = request()->get('ref', '') != '' ? request()->get('ref') : route($ctrl . '.index'); ?>
                    <input type="hidden" name="ref" value="{{ $ref }}" />
                </div>
                @include('admin.partials._save_button')
            </form>
        </div>
    </div>
</section>
<!-- /.content -->
@endsection
@push('scripts')
<script type="text/javascript">
    $(function() {
            $(".item-box .form-control[type=file]").on('change', function(event) {
                var output = $(event.target).parents('.row').find('.preview');
                if (output.length > 0) {
                    output.empty();
                    var uu = URL.createObjectURL(event.target.files[0]);
                    output.append('<img src="' + uu + '" style="width:100%; height:auto" />');
                }
            });
            CKEDITOR.config.height = '50em';
        });
</script>
@endpush