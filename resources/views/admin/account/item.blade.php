<?php
$ctrl = 'admin.account';
$url = '';
$title = 'Tài khoản';
$btn = '';
$isDisabled = true;
if ($isAction == 'create') {
    $title = 'Thêm mới Tài khoản';
    $url = route($ctrl . '.store');
    $isDisabled = false;
    $btn = 'Lưu';
} elseif ($isAction == 'edit') {
    $title = 'Chỉnh sửa Tài khoản';
    $url = route($ctrl . '.update', $item['id']);
    $isDisabled = false;
    $btn = 'Cập nhật';
} elseif ($isAction == 'show') {
    $title = 'Xem thông tin Tài khoản';
    $url = '';
    $isDisabled = true;
}

$nav = ['BUDVAR' => route('admin.budvar.dashboard'), 'TÀI KHOẢN' => route($ctrl . '.index'), $title => '#'];
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
                    <input name="type" type="hidden" value="admin">
                    @csrf

                    <div class="row">
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-6">
                                    @include('admin.partials._input_val', [
                                        'title' => 'Họ Tên',
                                        'name' => 'name',
                                        'val' => old('name', isset($item['name']) ? $item['name'] : ''),
                                        'isRequired' => true,
                                    ])
                                </div>
                                <div class="col-sm-6">
                                    @include('admin.partials._input_val', [
                                        'title' => 'SĐT',
                                        'name' => 'phone',
                                        'val' => old('phone', isset($item['phone']) ? $item['phone'] : ''),
                                        'isRequired' => true,
                                        'minlength' => 10,
                                        'maxlength' => 10,
                                    ])
                                </div>
                                <div class="col-sm-6">
                                    @include('admin.partials._input_val', [
                                        'title' => 'Email',
                                        'name' => 'email',
                                        'type' => 'email',
                                        'val' => old('email', isset($item['email']) ? $item['email'] : ''),
                                        'isRequired' => true,
                                    ])
                                </div>
                                <div class="col-sm-6">
                                    @include('admin.partials._input_select2', [
                                        'title' => 'Status',
                                        'name' => 'status',
                                        'array' => \App\Common\Enum_STATUS::getArray(),
                                        'val' => old('status', isset($item['status']) ? $item['status'] : ''),
                                    ])
                                </div>
                                <div class="col-sm-6">
                                    @include('admin.partials._input_select2', [
                                        'title' => 'Giới tính',
                                        'name' => 'gender',
                                        'array' => ['0' => 'Không xác định', '1' => 'Nam', '2' => 'Nữ'],
                                        'val' => old('gender', isset($item['gender']) ? $item['gender'] : ''),
                                    ])
                                </div>
                                <div class="col-sm-6">
                                    @include('admin.partials._input_date', [
                                        'title' => 'Ngày sinh',
                                        'name' => 'birthday',
                                        'val' => old(
                                            'birthday',
                                            isset($item['birthday']) ? $item['birthday'] : ''),
                                    ])
                                </div>

                                @if ($isAction == 'create')
                                    <div class="col-sm-6">
                                        @include('admin.partials._input_val', [
                                            'title' => 'Mật khẩu',
                                            'name' => 'password',
                                            'type' => 'password',
                                            'minlength' => 4,
                                            'maxlength' => 16,
                                            'val' => '',
                                            'isRequired' => true,
                                        ])
                                    </div>
                                    <div class="col-sm-6">
                                        @include('admin.partials._input_val', [
                                            'title' => 'Xác nhận mật khẩu',
                                            'name' => 'password_confirmation',
                                            'type' => 'password',
                                            'minlength' => 4,
                                            'maxlength' => 16,
                                            'val' => '',
                                            'isRequired' => true,
                                        ])
                                    </div>
                                @endif

                                <?php 
                                 $isBudvar = in_array("Budvar", $user_configs) ? 1 : 0;
                                 $isTechicoo = in_array("Techicoo", $user_configs) ? 1 : 0;
                                 $isAdmin = in_array("Administrator", $user_configs) ? 1 : 0;
                                ?>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="checkbox icheck">
                                                <label> <input type="checkbox" name="isBudvar" value="1"
                                                        {{ old('isBudvar', isset($isBudvar) ? $isBudvar : 0) == 1 ? 'checked' : '' }}
                                                        {{ $isDisabled ? 'disabled' : '' }}>
                                                    {{ __('Tài khoản Budvar') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="checkbox icheck">
                                                <label> <input type="checkbox" name="isTechicoo" value="1"
                                                        {{ old('isTechicoo', isset($isTechicoo) ? $isTechicoo : 0) == 1 ? 'checked' : '' }}
                                                        {{ $isDisabled ? 'disabled' : '' }}> {{ __('Tài khoản Techicoo') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="checkbox icheck">
                                                <label> <input type="checkbox" name="isAdmin" value="1"
                                                        {{ old('isAdmin', isset($isAdmin) ? $isAdmin : 0) == 1 ? 'checked' : '' }}
                                                        {{ $isDisabled ? 'disabled' : '' }}>
                                                    {{ __('Tài khoản Administrator') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group" {{ $isAction == 'show' ? 'hidden' : '' }}>
                                <label for="avatar">Avatar</label>
                                <input type="file" name="avatar" id="avatar"
                                    class="form-control form-control-file-img" accept="image/png, image/jpeg">

                            </div>
                            <div class="preview">
                                @if ($isAction == 'edit' || $isAction == 'show')
                                    <img src="{{ $item['avatar'] }}" style="width:100%; height:auto" />
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
