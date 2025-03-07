<meta charset="utf-8" />
<!-- <title>Color Admin | @yield('title')</title> -->
<title>MATIX UP CEBU</title>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
<meta content="" name="description" />
<meta content="" name="author" />

<!-- ================== BEGIN core-css ================== -->
<link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/default/app.min.css') }}" rel="stylesheet" />
<!-- ================== END core-css ================== -->

<!-- needed css files -->
<link href="/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="/assets/css/custome.css" rel="stylesheet" />
<link rel="shortcut icon" href="{{url('web/assets/img/matix_logo_white.png')}}?{{ mt_rand() }}">
<!-- ================== END BASE CSS STYLE ================== -->
<link href="/assets/plugins/switchery/dist/switchery.min.css" rel="stylesheet" />
<link href="/assets/plugins/abpetkov-powerange/dist/powerange.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link href="/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />

<link href="/assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="/assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />
<link href="/assets/plugins/datatables.net-scroller-bs5/css/scroller.bootstrap5.min.css" rel="stylesheet" />


@stack('css')
