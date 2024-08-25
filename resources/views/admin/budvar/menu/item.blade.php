<?php
$url = '';
$btn = '';
$isDisabled = true;
if ($isAction == 'create') {
    $url = route($ctrl . '.store');
    $isDisabled = false;
    $btn = 'Lưu';
} elseif ($isAction == 'edit') {
    $url = route($ctrl . '.update', $item['_id']);
    $isDisabled = false;
    $btn = 'Cập nhật';
} elseif ($isAction == 'show') {
    $url = '';
    $isDisabled = true;
}
?>

@extends('admin.layouts.app')
@section('content')

<section class="app-content ">

    <div class="card card-secondary card-outline  mb-4 mt-4 item-box">
        <div class="card-body">
            @include('admin.partials._alerts')

            <form class="form-item" method="POST" action="{{ $url }}" enctype="multipart/form-data">
                @if ($isAction == 'edit')
                <input name="_method" type="hidden" value="PATCH">
                @endif
                @csrf

                <div class="row">
                    <div class="col-sm-12">
                        @include('admin.partials._input_val', [
                        'title' => 'Tên',
                        'name' => 'name',
                        'val' => old('name', isset($item['name']) ? $item['name'] : ''),
                        'isRequired' => true,
                        ])
                    </div>
                    <div class="col-sm-6">
                        @include('admin.partials._input_val', [
                        'title' => 'Link',
                        'name' => 'link',
                        'val' => old('link', isset($item['link']) ? $item['link'] : ''),
                        'isRequired' => true,
                        ])
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label" for="{{ 'input_parentID'}}">{{ 'Cấp trên' }}</label>
                            <select class="form-control  select2" style="width: 100%;" id="{{ 'input_parentID' }}" name="{{ 'parentID' }}">
                                <option value=""> {{ '-- Chọn cấp trên --' }}</option>
                                <?php $_val = old('parentID', isset($item['parentID']) ? $item['parentID']['_id'] : ''); ?>
                                @if (count($menus) > 0)
                                @foreach ($menus as $k => $v)
                                <option value="{{ $v['_id'] }}" {{ ($v['_id']==$_val) ? 'selected' : '' }}>{{ $v['name'] . ' (' . $v['location'] .')' }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        @include('admin.partials._input_select2', [
                        'title' => 'Ngôn ngữ',
                        'array' => \App\Common\Enum_LANG::getArray(),
                        'name' => 'lang',
                        'val' => old('lang', isset($item['lang']) ? $item['lang'] : ''),
                        'isRequired' => true,
                        ])
                    </div>
                    <div class="col-sm-6">
                        @include('admin.partials._input_select2', [
                        'title' => 'Vị trí',
                        'name' => 'location',
                        'array' => ['TOP' => 'TOP', 'BOTTOM' => 'BOTTOM'],
                        'val' => old('location', isset($item['location']) ? $item['location'] : ''),
                        ])
                    </div>
                    <div class="col-sm-6">
                        @include('admin.partials._input_select2', [
                        'title' => 'Status',
                        'name' => 'status',
                        'array' => ['A' => 'A', 'F' => 'F'],
                        'val' => old('status', isset($item['status']) ? $item['status'] : ''),
                        //'hiden' => true
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