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

        <div class="card card-secondary card-outline mb-4 mt-4 item-box">
            <div class="card-body">

                @include('admin.partials._alerts')

                <form class="form-item" method="POST" action="{{ $url }}" enctype="multipart/form-data">
                    @if ($isAction == 'edit')
                        <input name="_method" type="hidden" value="PATCH">
                    @endif
                    @csrf

                    <div class="row">
                        <div class="col-sm-9">
                            @include('admin.partials._input_val', [
                                'title' => 'Tiêu đề',
                                'name' => 'name',
                                'val' => old('name', isset($item['name']) ? $item['name'] : ''),
                                'isRequired' => true,
                            ])
                            <div class="row">
                                <div class="col">
                                    @include('admin.partials._input_select2_list', [
                                    'title' => 'Loại',
                                    'array' => $categories,
                                    'val_field' => 'title',
                                    'id_field' => '_id',
                                    'name' => 'category',
                                    'val' => old('category', isset($item['category']) ? $item['category'] : ''),
                                    'all_title' => '-- Loại --',
                                    'isRequired' => true,
                                    ])
                                </div>
                                <div class="col">
                                    @include('admin.partials._input_select2', [
                                    'title' => 'Ngôn ngữ',
                                    'array' => \App\Common\Enum_LANG::getArray(),
                                    'name' => 'lang',
                                    'val' => old('lang', isset($item['lang']) ? $item['lang'] : ''),
                                    'isRequired' => true,
                                    ])
                                </div> 
                            </div>

                            @include('admin.partials._input_text', [
                                'title' => 'Mô tả',
                                'name' => 'short',
                                'val' => old('short', isset($item['short']) ? $item['short'] : ''),
                                'row' => 3,
                                'isRequired' => true,
                            ])
                            @include('admin.partials._input_ckeditor', [
                                'title' => 'Nội dung',
                                'name' => 'description',
                                'val' => old(
                                    'description',
                                    isset($item['description']) ? $item['description'] : ''),
                            ])
                        </div>
                        <div class="col-sm-3">

                            <div class="form-group" {{ $isAction == 'show' ? 'hidden' : '' }}>
                                <label for="thumb">Thumb</label>
                                <input type="file" name="thumb" id="thumb"
                                    class="form-control form-control-file-img" accept="image/*">

                            </div>
                            <div class="preview">
                                @if ($isAction == 'edit' || $isAction == 'show')
                                    <img src="{{ \App\Common\Utility::displayBudvarMedia(isset($item['media']) ? $item['media'] : '') }}"
                                        style="width:100%; height:auto" />
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <?php $ref = request()->get('ref', '') != '' ? request()->get('ref') :  ($isAction == 'create' ? route($ctrl . '.index') : route($ctrl . '.edit', $item['_id'])); ?>
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
