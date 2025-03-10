<!DOCTYPE html>
<html lang="en">

<head>
    @include('web.components.head')
</head>

<body class="index-page">

    @include('web.components.header')

    @yield('content')

    @include('web.components.footer')

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="/web/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/web/assets/vendor/php-email-form/validate.js"></script>
    <script src="/web/assets/vendor/aos/aos.js"></script>
    <script src="/web/assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="/web/assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="/web/assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="/web/assets/js/main.js"></script>
</body>

</html>