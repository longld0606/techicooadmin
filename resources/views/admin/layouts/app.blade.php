<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>CONOORAN | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="CONOORAN | Dashboard v2">
    <meta name="author" content="CONOORAN">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard">

    <link rel="stylesheet" href="/assets/admin/vendor/select2/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/admin/vendor/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="/assets/admin/vendor/iCheck/square/blue.css">

    <link rel="stylesheet" href="/assets/admin/vendor/datatables/datatables-all.min.css">
    {{--
    <link rel="stylesheet" href="/assets/admin/vendor/datatables/css/dataTables.bootstrap5.min.css"> --}}
    <link rel="stylesheet" href="/assets/admin/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/assets/admin/vendor/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <link rel="stylesheet" href="/assets/theme/css/adminlte.css">
    <!--end::Required Plugin(AdminLTE)-->
    <!-- apexcharts -->
    <link rel="stylesheet" href="/assets/admin/css/app.css?v={{ time() }}">
    @stack('style')
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header--> 
        @include('admin.layouts.header') 
        
        @if(auth("admin")->user()->hasRole('Budvar'))
        @include('admin.layouts.sidebar_main_budvar')
        @else
        @include('admin.layouts.sidebar_main')
        @endif
      
        <main class="app-main">
            <!--begin::App Content Header-->
            @yield('content')
        </main>
        <!--end::App Main-->
        <!--begin::Footer-->
    </div>
    <div className="ajaxInProgress" style='display:none'>
        <div class="loading-ct"><i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>
            <div class="load-msg"></div>
        </div>
    </div>
    <script src="/assets/admin/vendor/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script>

    <script src="/assets/admin/vendor/datatables/datatables-all.min.js"></script>
    <script src="/assets/admin/vendor/select2/select2.min.js"></script>
    <script src="/assets/admin/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/admin/vendor/ckeditor/ckeditor.js"></script>
    <script src="/assets/admin/vendor/ckeditor/plugins/justify/plugin.js"></script>
    {{-- <script src="/assets/admin/vendor/ckeditor/plugins/file-manager/plugin.js"></script> --}}
    <script src="/assets/admin/vendor/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- iCheck -->
    <!-- sweetalert thong bao - longld -->
    <script src="/assets/admin/vendor/sweetalert/sweetalert.min.js"></script>
    <!-- notify - longld-->
    <script src="/assets/admin/vendor/notify/notify.min.js"></script>
    <!-- iCheck -->
    <script src="/assets/admin/vendor/iCheck/icheck.min.js"></script>

    <script src="/assets/theme/js/adminlte.js"></script>
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (
                sidebarWrapper &&
                typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
    <script src="/assets/admin/js/app.js?v={{ time() }}"></script>
    @stack('scripts')
</body>
<!--end::Body-->

</html>