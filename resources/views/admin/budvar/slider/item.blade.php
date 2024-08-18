@extends('admin.layouts.app')
<?php
$ctrl = 'admin.budvar.slider';
$url = '';
$title = 'Slider';
$btn = '';
$isDisabled = true;
if ($isAction == 'create') {
    $title = 'Thêm mới Slider';
    $url = route($ctrl . '.store');
    $isDisabled = false;
    $btn = 'Lưu';
} elseif ($isAction == 'edit') {
    $title = 'Chỉnh sửa Slider';
    $url = route($ctrl . '.update', $item['_id']);
    $isDisabled = false;
    $btn = 'Cập nhật';
} elseif ($isAction == 'show') {
    $title = 'Xem thông tin Slider';
    $url = '';
    $isDisabled = true;
}

$nav = ['BUDVAR' => route('admin.budvar.dashboard'), 'SLIDER' => route($ctrl . '.index'), $title => '#'];
?>

@section('title', $title)
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
                    <input name="type" type="hidden" value="BANNER">
                    @csrf

                    <div class="row">
                        <div class="col-sm-6">
                            @include('admin.partials._input_val', [
                                'title' => 'Code',
                                'name' => 'code',
                                'val' => old('code', $item['code']),
                            ])
                            @include('admin.partials._input_val', [
                                'title' => 'Tiêu đề',
                                'name' => 'name',
                                'val' => old('name', $item['name']),
                            ]) 
                            @include('admin.partials._input_val', [
                                'title' => 'Link',
                                'name' => 'link',
                                'val' => old('link', isset($item['link']) ?  $item['link'] : '' ),
                            ])
                            @include('admin.partials._input_val', [
                                'title' => 'Text',
                                'name' => 'textButton',
                                'val' => old('textButton', isset($item['textButton']) ?  $item['textButton'] : '' ),
                            ])
                        </div>
                        <div class="col-sm-6" >

                            <div class="form-group" {{ $isAction == 'show' ? 'hidden' : '' }}>
                                <label for="thumb">Thumb</label>
                                <input type="file" name="thumb" id="thumb"
                                    class="form-control form-control-file-img" accept="image/png, image/jpeg">

                            </div>
                            <div class="preview">
                                @if ($isAction == 'edit' || $isAction == 'show')
                                    <img src="{{ \App\Common\Utility::displayBudvarMedia($item['media']) }}"  style="width:100%; height:auto" />
                                @endif
                            </div>
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
