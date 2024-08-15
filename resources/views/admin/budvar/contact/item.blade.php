@extends('admin.layouts.app')
<?php 
$title = 'Thông tin Contact';

?>

@section('title', $title)
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        {{ $title }}
                    </h3>
                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <label>Tài khoản</label>
                            <p>{{ ($item->user_name) }}({{$item->user_id }})</p>
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
                    <h4 style="font-weight: bold; padding-top: 15px; padding-bottom:15px;">Request</h4>
                    <div class="row">
                        <div class="col-sm-12">
                            @if($item->headers)
                            <pre>{{ ($item->headers) }}</pre>
                            @endif
                            @if($item->request)
                            <pre>{{ $item->request }}</pre>
                            @endif
                        </div>
                    </div>
                    <h4 style="font-weight: bold; padding-top: 15px; padding-bottom:15px;">Response</h4>
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
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
@endsection

@push('scripts')