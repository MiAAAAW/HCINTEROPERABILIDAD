<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ !empty($header_title) ? $header_title : '' }} Residentado</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    {{-- Enlace a Font Awesome (local) --}}
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Ionicons (opcional) -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!--
      ========================================
      MANTENEMOS SOLO UNA VERSIÓN DE BOOTSTRAP
      PARA EVITAR CONFLICTOS CON ADMINLTE.
      ========================================
    -->
    <!-- Bootstrap 4 (Recomendado para AdminLTE 3) -->
    {{-- Si quieres usar Bootstrap 5, comenta el de abajo y descomenta el de arriba,
         pero ten en cuenta que AdminLTE 3 puede tener conflictos. --}}
    <!-- AdminLTE ya trae Bootstrap 4 integrado en "plugins/bootstrap/js/bootstrap.bundle.min.js",
         así que no necesariamente requieres un CDN de Bootstrap 4 adicional. -->

    <!-- AdminLTE CSS (usa Bootstrap 4 internamente) -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">

    <!-- Summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> <!-- Colores personalizados -->

    <!-- Favicon / Icon theme -->
    <link rel="shortcut icon" href="{{ asset('assets/imgs/iconcollao.png') }}" type="image/x-icon">

    @yield('style')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Opcional: Preloader
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="{{url('public/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
    </div>
    -->

    @include('layouts.header')

    {{-- Contenido principal --}}
    @yield('content')

    @include('layouts.footer')
    <!-- /.control-sidebar -->

</div>
<!-- ./wrapper -->

<!--
  ==============================================
   SCRIPTS
   Mantén una sola versión de jQuery y Bootstrap
   para evitar conflictos.
  ==============================================
-->

<!-- jQuery (versión incluida con AdminLTE) -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>

<!-- Resolver conflicto entre jQuery UI y Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>

<!-- Bootstrap 4 (bundled con AdminLTE) -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>

<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>

<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>

<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>

<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

<!-- AdminLTE Dashboard Demo (opcional) -->
{{-- <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script> --}}

<!--
   =================================
   Scripts que tenías del CDN
   Se comentan para evitar conflictos.
   =================================
-->

<!--
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
-->

<!--
   Aquí puedes conservar los scripts viejos (dupli)
   si deseas referenciarlos en algún momento como
   "ejemplo" o en caso de migración a Bootstrap 5.
-->

@yield('script')
</body>
</html>
