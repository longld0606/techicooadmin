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

                        @include('admin.partials._input_val', [
                            'title' => 'Name',
                            'name' => 'name',
                            'val' => old('name', isset($item['name']) ? $item['name'] : ''),
                            'isRequired' => true,
                        ])
                        <div class="row">

                            <div class="col">
                                @include('admin.partials._input_select2', [
                                    'title' => 'Language',
                                    'array' => \App\Common\Enum_LANG::getArray(),
                                    'name' => 'lang',
                                    'val' => old('lang', isset($item['lang']) ? $item['lang'] : ''),
                                    'isRequired' => true,
                                ])
                            </div>
                            <div class="col">
                                @include('admin.partials._input_val', [
                                    'title' => 'Mixed',
                                    'name' => 'mixed',
                                    'val' => old('mixed', isset($item['mixed']) ? $item['mixed'] : ''),
                                    'isRequired' => false,
                                ])
                            </div>
                        </div>

                        @include('admin.partials._input_text', [
                            'title' => 'Description',
                            'name' => 'description',
                            'val' => old('description', isset($item['description']) ? $item['description'] : ''),
                            'row' => 6,
                            'isRequired' => true,
                        ])

                        <div class="col-sm-6">
                            <div class="form-group" {{ $isAction == 'show' ? 'hidden' : '' }}>
                                <label for="thumb">Thumb</label>
                                <input type="file" name="thumbs[]" id="thumbs"
                                    class="form-control form-control-file-img" accept="image/*" multiple>

                            </div>
                            <div class="preview pv-thumbs">
                                @if (($isAction == 'edit' || $isAction == 'show') && isset($item['medias']) && count($item['medias']) > 0)
                                    @foreach ($item['medias'] as $m)
                                        <div class="prv-img">
                                            @if ($isAction == 'edit')
                                                <div class="position-absolute" style="right: 15px"> <button type="button"
                                                        class="btn btn-danger btn-sm  btn-img-remove"
                                                        data-id="{{ $m['_id'] }}"><i class="fa fa-trash"></i>&nbsp;
                                                        Xóa</button></div>
                                            @endif
                                            <img src="{{ \App\Common\Utility::displayBudvarMedia($m) }}"
                                                style="width:100%; height:auto" />
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group" {{ $isAction == 'show' ? 'hidden' : '' }}>
                                <label for="icons">Icons</label>
                                <input type="file" name="icons[]" id="icons"
                                    class="form-control form-control-file-img" accept="image/*" multiple>

                            </div>
                            <div class="preview pv-icons">
                                @if (($isAction == 'edit' || $isAction == 'show') && isset($item['medias']) && count($item['medias']) > 0)
                                    @foreach ($item['medias'] as $m)
                                        <div class="prv-img">
                                            @if ($isAction == 'edit')
                                                <div class="position-absolute" style="right: 15px"> <button type="button"
                                                        class="btn btn-danger btn-sm  btn-img-remove"
                                                        data-id="{{ $m['_id'] }}"><i class="fa fa-trash"></i>&nbsp;
                                                        Xóa</button></div>
                                            @endif
                                            <img src="{{ \App\Common\Utility::displayBudvarMedia($m) }}"
                                                style="width:100%; height:auto" />
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        <?php $ref = request()->get('ref', '') != '' ? request()->get('ref') : ($isAction == 'create' ? route($ctrl . '.index') : route($ctrl . '.edit', $item['_id'])); ?>
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
            $(".item-box .form-control#thumbs").on('change', function(event) {
                var output = $(event.target).parents('.row').find('.preview.pv-thumbs');
                output.find('.prv-img.prv-add').empty();
                html = '';
                var files = event.target.files;
                for (var i = 0; i < files.length; i++) {
                    var uu = URL.createObjectURL(files[i]);
                    html += ('  <div class="prv-img prv-add" >' +
                        ' <img src="' + uu +
                        '" style="width:100%; height:auto; border: 1px solid #ccc;" /></div>');
                }
                output.prepend(html);
            });
            CKEDITOR.config.height = '30em';

            $(".preview.pv-thumbs").on('click', '.btn-img-remove', function(e) {
                // var _id = $(e.target).data('id');
                // if(_id.length > 0){
                //     $f = $('form.form-item').append('<input name="mediasRemove[]" type="hidden" value="'+_id+'">')
                // }
                $(e.target).parents('.prv-img').remove();
            })

            $(".item-box .form-control#icons").on('change', function(event) {
                var output = $(event.target).parents('.row').find('.preview.pv-icons');
                output.find('.prv-img.prv-add').empty();
                html = '';
                var files = event.target.files;
                for (var i = 0; i < files.length; i++) {
                    var uu = URL.createObjectURL(files[i]);
                    html += ('  <div class="prv-img prv-add" >' +
                        ' <img src="' + uu +
                        '" style="width:100%; height:auto; border: 1px solid #ccc;" /></div>');
                }
                output.prepend(html);
            });
            $(".preview.pv-icons").on('click', '.btn-img-remove', function(e) {
                // var _id = $(e.target).data('id');
                // if(_id.length > 0){
                //     $f = $('form.form-item').append('<input name="mediasRemove[]" type="hidden" value="'+_id+'">')
                // }
                $(e.target).parents('.prv-img').remove();
            })
        });
    </script>
@endpush
