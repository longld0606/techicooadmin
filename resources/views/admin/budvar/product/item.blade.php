@extends('admin.layouts.app')
<?php
$ctrl = 'admin.budvar.product';
$url = '';
$title = 'Sản phẩm';
$btn = '';
$isDisabled = true;
if ($isAction == 'create') {
    $title = 'Thêm mới Sản phẩm';
    $url = route($ctrl . '.store');
    $isDisabled = false;
    $btn = 'Lưu';
} elseif ($isAction == 'edit') {
    $title = 'Chỉnh sửa Sản phẩm';
    $url = route($ctrl . '.update', $item['_id']);
    $isDisabled = false;
    $btn = 'Cập nhật';
} elseif ($isAction == 'show') {
    $title = 'Xem thông tin Sản phẩm';
    $url = '';
    $isDisabled = true;
}

$nav = ['BUDVAR' => route('admin.budvar.dashboard'), 'SẢN PHẨM' => route($ctrl . '.index'), $title => '#'];
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
                    @csrf

                    <div class="row">
                        <div class="col-sm-9">
                            @include('admin.partials._input_val', [
                                'title' => 'Tiêu đề',
                                'name' => 'name',
                                'val' => old('name', empty($item['name'])? '' : $item['name']),
                                'isRequired'=>true
                            ])
                              @include('admin.partials._input_select2_list', [
                                'title' => 'Loại',
                                'array' => $categories,
                                'val_field' => 'title',
                                'id_field' => '_id',
                                'name' => 'category',
                                'val' => old('category', (empty($item['category'])? '' : $item['category'])),
                                'all_title' => '-- Loại --',
                                'isRequired'=>true
                            ])
                            @include('admin.partials._input_text', [
                                'title' => 'Mô tả',
                                'name' => 'short',
                                'val' => old('short', empty($item['short'])? '' : $item['short']),
                                'row'=>5,
                                'isRequired'=>true
                            ])
                            @include('admin.partials._input_ckeditor', [
                                'title' => 'Nội dung',
                                'name' => 'description',
                                'val' => old('description', empty($item['description'])? '' : $item['description']),
                                'row'=>30,
                            ])
                        </div>
                        <div class="col-sm-3">

                            <div class="form-group"  {{ $isAction == 'show' ? 'hidden' : '' }}>
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
