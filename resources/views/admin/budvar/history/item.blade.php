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
                    @foreach ($inputs as $input )
                    <div class="col-sm-{{ $input->col }}">
                        <?php $vie = 'admin.partials.'.\App\Common\ApiInputModel::getView($input->type); ?>
                        @include($vie, [
                        'title' => $input->title,
                        'name' => $input->name. ($input->multiple ? '[]': ''),
                        'val' => old($input->name,isset($item[$input->name]) ? $item[$input->name] : ($input->multiple ? []: '')),
                        'isRequired' => isset($input->isRequired) ? $input->isRequired : false ,
                        'array' => isset($input->array) ? $input->array : [],
                        'all_title' => isset($input->all_title) ? $input->all_title : '',
                        'id_field' => isset($input->id_field) ? $input->id_field : 'id',
                        'val_field' => isset($input->val_field) ? $input->val_field : 'title',
                        'multiple' => isset($input->multiple) ? $input->multiple : 'title',
                        'isDisabled' => $isDisabled,
                        ])
                    </div>
                    @endforeach
                    <div class="card-body">
                        <?php $ref = request()->get('ref', '') != '' ? request()->get('ref') : route($ctrl . '.index'); ?>
                        <input type="hidden" name="ref" value="{{ $ref }}" />
                    </div>
                    @include('admin.partials._save_button')
                </div>
            </form>
        </div>
    </div>
</section>
<!-- /.content -->
@endsection
@push('scripts')
@endpush