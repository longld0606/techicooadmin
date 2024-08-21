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
    $url = route($ctrl . '.update', $item['_id']);
    $isDisabled = false;
    $btn = 'Cập nhật';
} elseif ($isAction == 'show') {
    $title = 'Xem thông tin PAGE';
    $url = '';
    $isDisabled = true;
}

$nav = ['BUDVAR' => route('admin.budvar.dashboard'), 'PAGE' => route($ctrl . '.index'), $title => '#'];

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
                    @csrf

                    <div class="row">
                        <div class="col-sm-9">
                            @include('admin.partials._input_val', [
                                'title' => 'Tiêu đề',
                                'name' => 'title',
                                'val' => old('title', isset($item['title']) ? $item['title'] : ''),
                            ])
                            <div class="row">
                                <div class="col">
                                    @include('admin.partials._input_select2', [
                                        'title' => 'Loại',
                                        'name' => 'type',
                                        'array' => \App\Common\Enum_PageType::getArray(),
                                        'val' => old('type', isset($item['type']) ? $item['type'] : ''),
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
                            ])
                            <?php
                            $sections = old('sections[]', isset($item['sections']) ? $item['sections'] : []);
                            if (count($sections) == 0) {
                                $sections = [''];
                            }
                            ?>
                            <div class="box-ck">
                                <div class="d-flex justify-content-start">
                                    <button type="button" class="btn btn-primary btn-sm btn-ck-add"><i
                                            class="fa fa-plus"></i>&nbsp; Thêm nội dung</button>
                                </div>
                                @foreach ($sections as $k => $s)
                                    <div class="box-content-item">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-danger btn-sm  btn-ck-remove"><i
                                                    class="fa fa-trash"></i>&nbsp; Xóa</button>
                                        </div>
                                        @include('admin.partials._input_ckeditor', [
                                            'title' => 'Nội dung',
                                            'name' => 'sections[]',
                                            'val' => $s,
                                            'inputId' => 'input_ck_' . $k,
                                        ])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group" {{ $isAction == 'show' ? 'hidden' : '' }}>
                                <label for="thumb">Thumb</label>
                                <input type="file" name="thumbs[]" id="thumbs"
                                    class="form-control form-control-file-img" accept="image/*" multiple>

                            </div>
                            <div class="preview">
                                @if (($isAction == 'edit' || $isAction == 'show') && isset($item['medias']) && count($item['medias']) > 0)
                                    @foreach ($item['medias'] as $m)
                                        <div class="prv-img" >
                                        @if ($isAction == 'edit')
                                            <div class="position-absolute" style="right: 15px"> <button type="button"
                                                    class="btn btn-danger btn-sm  btn-img-remove" data-id="{{ $m['_id'] }}"><i
                                                        class="fa fa-trash"></i>&nbsp; Xóa</button></div>
                                        @endif
                                        <img src="{{ \App\Common\Utility::displayBudvarMedia($m) }}" style="width:100%; height:auto" />
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <?php $ref = request()->get('ref', '') != '' ? request()->get('ref') : route($ctrl . '.edit', $item['_id']); ?>
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
                output.find('.prv-img.prv-add').empty();
                html = '';
                var files = event.target.files;
                for (var i = 0; i < files.length; i++) {
                    var uu = URL.createObjectURL(files[i]);
                    html += ('  <div class="prv-img prv-add" >'                            
                        +' <img src="' + uu + '" style="width:100%; height:auto; border: 1px solid #ccc;" /></div>');
                }
                output.prepend(html);
            });
            CKEDITOR.config.height = '30em';

            $(".box-ck").on('click', '.btn-ck-add', function(e) {
                var html = $('.box-ck').find('.box-content-item')[0].cloneNode(true);
                var _id = 'ckid_' + Date.now();
                $(html).find('textarea').attr('id', _id).css('display', 'block');
                $(html).find('textarea').val('');
                $(html).find('div.cke').remove();
                $('.box-ck').append(html);
                initInput(_id);
            })

            $(".box-ck").on('click', '.btn-ck-remove', function(e) {
                var length = $('.box-ck').find('.box-content-item');
                if ($('.box-ck').find('.box-content-item').length <= 1) {
                    alert('Không có dữ liệu cần xóa')
                } else {
                    $(e.target).closest('.box-content-item').remove();
                }
            })
            $(".preview").on('click', '.btn-img-remove', function(e) {
                var _id = $(e.target).data('id');
                if(_id.length > 0){
                    $f = $('form.form-item').append('<input name="mediasRemove[]" type="hidden" value="'+_id+'">')
                }
                $(e.target).parents('.prv-img').remove();
            })

        });
    </script>
@endpush
