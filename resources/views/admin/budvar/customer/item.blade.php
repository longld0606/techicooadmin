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
                    @if($input->type == 'row' || $input->type == 'line')
                    <div class="col-sm-12"></div>
                    @else
                    <div class="col-sm-{{ $input->col }}">
                        <?php $vie = 'admin.partials.'.\App\Common\ApiInputModel::getView($input->type); ?>
                        @include($vie, [
                        'type' => (isset($input->type) ? $input->type : 'text'),
                        'title' => (isset($input->title) ? $input->title : ''),
                        'name' => (isset($input->name) ? $input->name : ''). (isset($input->multiple) && $input->multiple ? '[]': ''),
                        'val' => old($input->name,isset($item[$input->name]) ? $item[$input->name] : ($input->multiple ? []: '')),
                        'isRequired' => isset($input->isRequired) ? $input->isRequired : false ,
                        'array' => isset($input->array) ? $input->array : [],
                        'all_title' => isset($input->all_title) ? $input->all_title : '',
                        'id_field' => isset($input->id_field) ? $input->id_field : 'id',
                        'val_field' => isset($input->val_field) ? $input->val_field : 'title',
                        'multiple' => isset($input->multiple) ? $input->multiple : 'title',
                        'isDisabled' => $isDisabled || ((isset($input->type) ? $input->type : 'text') == "password" && $isAction != 'create'),
                        'hidden' =>((isset($input->type) ? $input->type : 'text') == "password" && $isAction != 'create')
                        ])
                    </div>
                    @endif
                    @endforeach

                    <div class="card-body">
                        <?php $ref = request()->get('ref', '') != '' ? request()->get('ref') : route($ctrl . '.index'); ?>
                        <input type="hidden" name="ref" value="{{ $ref }}" />
                        <input type="hidden" name="lat" value="" />
                        <input type="hidden" name="long" value="" />
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
<script src="/assets/admin/vendor/autocomplete/jquery.autocomplete.min.js"></script>
{{-- <script src="https://maps.googleapis.com/maps/api/js?key=" async defer></script> --}}
<script type="text/javascript">
    $(function() {
        // var flagSelect = false;
        // var flagChange = false;
        // var flagAjax = false;
        // $('#input_address')
        //     .autocomplete({
        //         minChars: 3,
        //         serviceUrl: '/admin/budvar/customer/address',
        //         onSelect: function (suggestion) {
        //             console.log('suggestion',suggestion);
        //             $('input[name=lat]').val(suggestion.lat);
        //             $('input[name=long]').val(suggestion.long);
        //             flagSelect = true;
        //         },
        //         // ajaxSettings:{
        //         //     beforeSend: showLoading,
        //         //     complete: hideLoading
        //         // }
        //         onHide: function(e){
        //             // $('#input_address').val('');
        //             // console.log('onHide',e);
        //             setTimeout(() => {
        //                 checkAddress();
        //             }, 250);
        //         },
        //         onSearchStart: function(e){
        //             $('input[name=lat]').val('');
        //             $('input[name=long]').val('');
        //         }
        //     })
        //     .on('change',function(){
        //         flagChange = true;
        //     });

        // function checkAddress(){
        //     console.log('check address',flagChange,flagSelect)
        //     // có đổi val mà ko phải từ selected
        //     if(flagChange == true && flagSelect == false){
        //         $('#input_address').val('');
        //         $('input[name=lat]').val('');
        //         $('input[name=long]').val('');
        //     }

        //     flagChange = false;
        //     flagSelect = false;
        // }
    });
</script>
@endpush
