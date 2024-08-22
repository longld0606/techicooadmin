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
                        'row' => 4,
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
