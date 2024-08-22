
<?php 
$isDisabled = true;
?>
@extends('admin.layouts.app')
@section('content')

<section class="app-content ">
    @include('admin.partials._alerts')

    <div class="card card-secondary card-outline mb-4 mt-4 search-box"> 
        <!-- /.box-header -->
        <div class="card-body">


            <div class="row">
                <div class="col-sm-4">
                    <label>Tài khoản</label>
                    <p>{{ ($item->user_name) }}{{ empty($item->user_id) ? '' : ('('.$item->user_id.')') }}</p>
                </div>
                <div class="col-sm-4">
                    <label>Thời gian</label>
                    <p>{{ \App\Common\Utility::displayDatetime($item->timestamp) }} </p>
                </div>
                <div class="col-sm-4">
                    <label>Ip</label>
                    <p>{{ ($item->ip) }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <label>Path</label>
                    <p>{{ ($item->path) }}</p>
                </div>
                <div class="col-sm-4">
                    <label>Method</label>
                    <p>{{ ($item->method) }}</p>
                </div>
            </div>
            <h5 style="font-weight: bold; padding-top: 15px; padding-bottom:15px;">Request</h5>
            <div class="row">
                <div class="col-sm-12">
                    @if($item->headers)
                    <pre>{{json_encode($item->headers) }}</pre>
                    @endif
                    @if($item->request)
                    <pre>{{ json_encode($item->request)  }}</pre>
                    @endif
                </div>
            </div>
            <h5 style="font-weight: bold; padding-top: 15px; padding-bottom:15px;">Response</h5>
            <div class="row">
                <div class="col-sm-12">
                    @if($item->response_code)
                    <p>{{ $item->response_code }}</p>
                    @endif
                    @if($item->response_message)
                    <p>{{ $item->response_message }}</p>
                    @endif
                    @if($item->response)
                    <pre>{{ $item->response }}</pre>
                    @endif
                </div>
            </div>

            <?php $ref = request()->get('ref', '') != '' ? request()->get('ref') : route('admin.' . $ctrl . '.index'); ?>
            <input type="hidden" name="ref" value="{{ $ref }}" />
        </div>
        <div class="card-footer">
            <div class="text-end">
                <a href="{{ $ref }}" class="btn btn-default btn-flat"> <i class="fa fa-chevron-left"></i> &nbsp;
                    Quay lại </a>
                @if (!$isDisabled)
                <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i>
                    &nbsp;{{ 'Lưu' }}</button>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
@endsection

@push('scripts')

@endpush