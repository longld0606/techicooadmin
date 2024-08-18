@extends('admin.layouts.app')
<?php
$ctrl = 'admin.budvar.category';
$url = '';
$title = 'Danh mục';
$btn = '';
$isDisabled = true;
if ($isAction == 'create') {
    $title = 'Thêm mới Danh mục';
    $url = route($ctrl . '.store');
    $isDisabled = false;
    $btn = 'Lưu';
} elseif ($isAction == 'edit') {
    $title = 'Chỉnh sửa Danh mục';
    $url = route($ctrl . '.update', $item['_id']);
    $isDisabled = false;
    $btn = 'Cập nhật';
} elseif ($isAction == 'show') {
    $title = 'Xem thông tin Danh mục';
    $url = '';
    $isDisabled = true;
}

$nav = ['BUDVAR' => route('admin.budvar.dashboard'), 'CATEGORY' => route($ctrl . '.index'), $title => '#'];
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
                    <input name="type" type="hidden" value="product">
                    @csrf

                    <div class="row">
                        <div class="col-sm-6">
                            @include('admin.partials._input_val', [
                                'title' => 'Tên',
                                'name' => 'title',
                                'val' => old('title', $item['title']),
                            ])
                        </div>
                        <div class="col-sm-6">
                            @include('admin.partials._input_select2', [
                                'title' => 'Status',
                                'name' => 'status',
                                'array' => ['A' => 'A', 'F' => 'F'],
                                'val' => old('status', $item['status']),
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
