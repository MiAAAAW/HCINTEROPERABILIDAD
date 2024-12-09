<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>El Collao - Ilave</title>

  {{-- <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('public/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{url('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('public/dist/css/adminlte.min.css')}}">

  <link rel="shortcut icon" href="{{url('public/assets/imgs/logoUnap.png')}}" type="image/x-icon"> --}}

   <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/imgs/iconcollao.png') }}" type="image/x-icon">


  <style>
    body, html {
      height: 100%;
      margin: 0;
      overflow: hidden;
    }
    .login-page {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      /* background: url('public/assets/recuperar.gif') no-repeat center center fixed; */
      background: url('{{ asset('assets/imgs/Ilave.png') }}') no-repeat center center fixed;
      background-size: 100% 100%;
    }
    .login-box {
      width: 360px;
      background: rgba(255, 255, 255, 0.5); /* Fondo blanco semitransparente */
      padding: 20px;
      border-radius: 10px;
    }
    @media (max-width: 576px) {
      .login-box {
        width: 90%;
        padding: 10px;
      }
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="" class="h3"><b>Municipalidad Provincial </b></a>
      <a href="" class="h3"><b>  EL Collao Ilave</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Inicie Sesión</p>

      @include('_message')

      <form action="{{url('login')}}" method="post">
        {{ csrf_field() }}
        <div class="input-group mb-3">
          <input type="text" class="form-control" required name="login" placeholder="Credenciales">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" required placeholder="Contraseña">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            {{-- <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember">
                Recuérdame
              </label>
            </div> --}}
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-block" style="background-color: #2527b1; border-color: #180ca2; color: white;">Iniciar</button>
          </div>
        </div>
      </form>

      {{-- <p class="mb-1">
        <a href="{{url('forgot-password')}}"><span style="color: #1403aa;">Olvidé mi Contraseña</a>
      </p> --}}
    </div>
  </div>
</div>

{{-- <!-- jQuery -->
<script src="{{url('public/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{url('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('public/dist/js/adminlte.min.js')}}"></script> --}}

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

</body>
</html>
