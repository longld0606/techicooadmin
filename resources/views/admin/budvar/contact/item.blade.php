<?php
$ctrl = 'admin.budvar.contact';
$url = '';
$title = 'Thông tin liên hệ';
$btn = '';
$isDisabled = true;
if ($isAction == 'create') {
    $title = 'Thêm mới liên hệ';
    $url = route($ctrl . '.store');
    $isDisabled = false;
    $btn = 'Lưu';
} elseif ($isAction == 'edit') {
    $title = 'Chỉnh sửa liên hệ';
    $url = route($ctrl . '.update', $item['_id']);
    $isDisabled = false;
    $btn = 'Cập nhật';
} elseif ($isAction == 'show') {
    $title = 'Xem thông tin liên hệ';
    $url = '';
    $isDisabled = true;
}

$nav = ['BUDVAR' => route('admin.budvar.dashboard'), 'KHÁCH HÀNG' => route($ctrl . '.index'), $title => '#'];

?>


@section('title', $title)
@extends('admin.layouts.app') 
@section('content')

    <section class="app-content ">

        <div class="card card-secondary  mb-4 mt-4 item-box">
            @include('admin.partials._card_title', ['title' => $title])
            <div class="card-body">

                @include('admin.partials._alerts')

                <form class="form-item" method="POST" action="{{ $url }}">
                    @if ($isAction == 'edit')
                        <input name="_method" type="hidden" value="PATCH">
                    @endif
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    @include('admin.partials._input_val', [
                                        'title' => 'Họ',
                                        'name' => 'firstname',
                                        'val' => old(
                                            'firstname',
                                            isset($item['firstname']) ? $item['firstname'] : ''),
                                    ])
                                </div>
                                <div class="col">
                                    @include('admin.partials._input_val', [
                                        'title' => 'Tên',
                                        'name' => 'lastname',
                                        'val' => old(
                                            'lastname',
                                            isset($item['lastname']) ? $item['lastname'] : ''),
                                    ])
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            @include('admin.partials._input_select2', [
                                'title' => 'Loại',
                                'name' => 'type',
                                'array' => ['contact' => 'Liên hệ', 'order' => 'Đặt hàng', 'event' => 'Sự kiện'],
                                'val' => old('type', isset($item['type']) ? $item['type'] : ''),
                            ])
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            @include('admin.partials._input_val', [
                                'title' => 'Email',
                                'type' => 'email',
                                'name' => 'email',
                                'val' => old('email', isset($item['email']) ? $item['email'] : ''),
                            ])
                        </div>
                        <div class="col">
                            @include('admin.partials._input_val', [
                                'title' => 'Số điện thoại',
                                'name' => 'phoneNumber',
                                'val' => old( 'phoneNumber', isset($item['phoneNumber']) ? $item['phoneNumber'] : ''),
                            ])
                        </div>
                    </div>

                    @include('admin.partials._input_text', [
                        'title' => 'Nội dung',
                        'name' => 'message',
                        'row' => 5,
                        'val' => old('message', isset($item['message']) ? $item['message'] : ''),
                    ])



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
@endpush
