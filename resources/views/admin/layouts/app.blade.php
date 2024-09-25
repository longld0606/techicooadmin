<!DOCTYPE html>
<html lang="en">

<head>
    <title>CONOORAN | {{ $title }}</title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
    	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    	<![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Conoran" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Css --->
    <link rel="icon" href="/assets/admin2/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/assets/admin2/css/plugins/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/admin2/css/plugins/select2.min.css">
    <link rel="stylesheet" href="/assets/admin2/css/plugins/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="/assets/admin2/css/plugins/bootstrap-tagsinput-typeahead.css">
    <link rel="stylesheet" href="/assets/admin/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/iCheck/square/blue.css">
    <link rel="stylesheet" href="/assets/admin/vendor/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="/assets/admin2/css/style.css">
    <link rel="stylesheet" href="/assets/admin/css/app2.css?v={{ time() }}">
    @stack('style')
</head>

<body class="">
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ navigation menu ] start -->
    @include('admin.layouts.sidebar')
    <!-- [ navigation menu ] end -->
    <!-- [ Header ] start -->
    @include('admin.layouts.header')
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <section class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            @include('admin.layouts.page_header')
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            @yield('content')
            <!-- [ Main Content ] end -->
        </div>
    </section>
    <div id="modal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </div>
    </div>

    <div className="ajaxInProgress" style='display:none'>
        <div class="loading-ct"><i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>
            <div class="load-msg"></div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
        @csrf
    </form>
    <!-- Required Js -->
    <script src="/assets/admin2/js/vendor-all.min.js"></script>
    <script src="/assets/admin2/js/plugins/bootstrap.min.js"></script>
    <script src="/assets/admin2/js/ripple.js"></script>
    <script src="/assets/admin2/js/pcoded.min.js"></script>
    <script src="/assets/admin2/js/menu-setting.min.js"></script>
    <script src="/assets/admin/vendor/notify/notify.min.js"></script>

    <!-- sweet alert Js -->
    <script src="/assets/admin2/js/plugins/sweetalert.min.js"></script>
    <script src="/assets/admin2/js/plugins/jquery.dataTables.min.js"></script>
    <script src="/assets/admin2/js/plugins/dataTables.bootstrap4.min.js"></script>

    <script src="/assets/admin/vendor/ckeditor/ckeditor.js"></script>
    <script src="/assets/admin/vendor/ckeditor/plugins/justify/plugin.js"></script>
    <script src="/assets/admin/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/admin/vendor/iCheck/icheck.min.js"></script>


    <script src="/assets/admin2/js/plugins/bootstrap-tagsinput.min.js"></script>
    <script src="/assets/admin2/js/plugins/bootstrap-maxlength.js"></script>
    <script src="/assets/admin2/js/plugins/select2.full.min.js"></script>


    <script src="/assets/admin/js/app2.js?v={{ time() }}"></script>
    @stack('scripts')
</body>

</html>
