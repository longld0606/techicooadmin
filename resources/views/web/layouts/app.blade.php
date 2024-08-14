<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Index - QuickStart Bootstrap Template</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicons -->
    <link href="assets/web/img/favicon.png" rel="icon">
    <link href="assets/web/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/web/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/web/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/web/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/web/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/web/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/web/css/main.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: QuickStart
  * Template URL: https://bootstrapmade.com/quickstart-bootstrap-startup-website-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

    @include('web.layouts.header')
    <main class="main">

        <!--begin::App Content Header-->
        @yield('content')

    </main>
    @include('web.layouts.footer')

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/web/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/web/vendor/php-email-form/validate.js"></script>
    <script src="assets/web/vendor/aos/aos.js"></script>
    <script src="assets/web/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/web/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/web/js/main.js"></script>

</body>

</html>
