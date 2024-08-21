<?php
$ctrl = 'admin.role';
$url = '';
$title = 'Nhóm quyền';
$btn = '';
$isDisabled = true;
if ($isAction == 'create') {
    $title = 'Thêm mới nhóm quyền';
    $url = route($ctrl . '.store');
    $isDisabled = false;
    $btn = 'Lưu';
} elseif ($isAction == 'edit') {
    $title = 'Chỉnh sửa nhóm quyền';
    $url = route($ctrl . '.update', $item['id']);
    $isDisabled = false;
    $btn = 'Cập nhật';
} elseif ($isAction == 'show') {
    $title = 'Xem thông tin nhóm quyền';
    $url = '';
    $isDisabled = true;
}

$nav = ['BUDVAR' => route('admin.budvar.dashboard'), 'NHÓM QUYỀN' => route($ctrl . '.index'), $title => '#'];
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
                <input name="_method" type="hidden" value="PUT">
                @endif
                @csrf

                <div class="row">
                    <div class="col-sm-6 mb-3">
                        @include('admin.partials._input_val', [
                        'title' => 'Tên',
                        'name' => 'name',
                        'val' => old('name',isset($item['name']) ? $item['name'] : ''),
                        'isRequired' => true
                        ])
                    </div>
                    <div class="col-sm-6 mb-3">
                        @include('admin.partials._input_val', [
                        'title' => 'Tên',
                        'name' => 'guard_name',
                        'val' => old('guard_name',isset($item['guard_name']) ? $item['guard_name'] : ''),
                        'isRequired' => true,
                        'isDisabled' => true,
                        ])
                    </div>

                    <div class="col-sm-12 ">

                        <div class="tools mb-3">
                            <label class="fw-none">
                                <input value="all" type="checkbox" name=""> Tất cả
                            </label>
                            &nbsp; &nbsp;
                            <label class="fw-none">
                                <input value="index" type="checkbox" name=""> Index - Danh sách
                            </label>
                            &nbsp; &nbsp;
                            <label class="fw-none">
                                <input value="add" type="checkbox" name=""> Add - Thêm
                            </label>
                            &nbsp; &nbsp;
                            <label class="fw-none">
                                <input value="edit" type="checkbox" name=""> Edit - Sửa
                            </label>
                            &nbsp; &nbsp;
                            <label class="fw-none">
                                <input value="delete" type="checkbox" name=""> Delete - Xóa
                            </label>
                        </div>

                        <h4 class="mb-3">Chức năng</h4>
                    </div>
                    <div class="col-sm-12 pers mb-3">
                        <div class="row">

                            @foreach ($allPers as $p)
                            <div class="col-sm-4">
                                <div class="">
                                    <label class="fw-none">
                                        <input type="checkbox" name="pers[]" value="{{ $p['id'] }}" {{ in_array($p['id'], old('pers[]', $role_pers?? [])) ?'checked':'' }} data-controller="{{ $p['controller']}}" data-action="{{ $p['action']}}">
                                        {{ $p['name'] }}
                                    </label>
                                </div>
                            </div>
                            @endforeach

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
        $('.tools input[type=checkbox]').on('ifChanged',  function(e){
            var ischeck = $(e.target).is(':checked');
            var val = $(e.target).val();
            if(val == 'all'){
                 $('.pers input[type=checkbox]').prop('checked',ischeck).iCheck('update');
            }else if(val == 'index'){ 
                 $('.pers input[type=checkbox][data-action=index]').prop('checked',ischeck).iCheck('update');           
                 $('.pers input[type=checkbox][data-action=show]').prop('checked',ischeck).iCheck('update');           
            }else if(val == 'add'){     
                $('.pers input[type=checkbox][data-action=create]').prop('checked',ischeck).iCheck('update');        
                $('.pers input[type=checkbox][data-action=store]').prop('checked',ischeck).iCheck('update');        
            }else if(val == 'edit'){ 
                $('.pers input[type=checkbox][data-action=edit]').prop('checked',ischeck).iCheck('update');        
                $('.pers input[type=checkbox][data-action=update]').prop('checked',ischeck).iCheck('update');   
            }else if(val == 'delete'){ 
               $('.pers input[type=checkbox][data-action=destroy]').prop('checked',ischeck).iCheck('update');   
            } 
            var _type = $(e.target).data('type'); 
            if(_type == 'Budvar'){
                $('.pers input[type=checkbox][data-type=destroy]').prop('checked',ischeck).iCheck('update');   
            }
        });
        $('.pers input[type=checkbox]').on('ifChanged',  function(e){
            var ischeck = $(e.target).is(':checked'); 
            var _type = $(e.target).data('controller');
            
            if(_type == 'Budvar'){
                $('.pers input[type=checkbox]').filter((i, elm) => { return $(elm).data('controller').indexOf('Budvar') > -1; }).prop('checked',ischeck).iCheck('update');   
            }
            else if(_type == 'Techicoo'){
                $('.pers input[type=checkbox]').filter((i, elm) => { return $(elm).data('controller').indexOf('Techicoo') > -1; }).prop('checked',ischeck).iCheck('update');   
            }
            else if(_type == 'Administrator'){
                $('.pers input[type=checkbox]').filter((i, elm) => { return ( $(elm).data('controller').indexOf('Budvar') == -1) &&  ($(elm).data('controller').indexOf('Techicoo') == -1); }).prop('checked',ischeck).iCheck('update');   
            }
        });
    });
</script>
@endpush