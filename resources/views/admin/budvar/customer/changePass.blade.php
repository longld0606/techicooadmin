@extends('admin.layouts.app')
@section('content')
<section class="app-content ">

    <div class="card card-secondary card-outline mb-4 mt-4 item-box">
        <div class="card-body">

            @include('admin.partials._alerts')

            <form class="form-item" method="POST" action="{{ route($ctrl . '.changePass', $item['_id']); }}" enctype="multipart/form-data">
                <input name="_method" type="hidden" value="PUT">
                @csrf

                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label">Họ và tên</label>
                            <input class="form-control" value="{{ $item['fullname'] }}" disabled />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input class="form-control" value="{{ $item['email'] }}" disabled />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label">SĐT</label>
                            <input class="form-control" value="{{ $item['phoneNumber'] }}" disabled />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label">MST</label>
                            <input class="form-control" value="{{ $item['taxCode'] }}" disabled />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu mới</label>
                            <input class="form-control" type="password" value="" name="password" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label">Nhập lại mật khẩu</label>
                            <input class="form-control" type="password" value="" name="repassword" />
                        </div>
                    </div>

                    <?php $ref = request()->get('ref', '') != '' ? request()->get('ref') : route($ctrl . '.index'); ?>
                    <div class="col-sm-12">
                        <div class="text-end">
                            <a href="{{ $ref }}" class="btn btn-default btn-flat"> <i class="fa fa-chevron-left"></i> &nbsp;
                                Quay lại </a>
                            <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i>
                                &nbsp;Cập nhật</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</section>
<!-- /.content -->
@endsection
@push('scripts')
<script type="text/javascript">
    $(function() {

    });
</script>
@endpush
