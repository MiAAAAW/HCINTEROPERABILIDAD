

 <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

    </ul>
  </nav>
  <!-- /**** -->

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="javascript:;" class="brand-link" style="text-align: center;">
      {{-- <img src="{{url('public/dist/img/minlog.png ')}}" alt=  "logo Residentado Medico" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
      <img src="{{ asset('dist/img/iconcollao.png') }}" alt="logo Collao Ilave" class="brand-image img-circle elevation-3" style="opacity: .8">

      <span class="brand-text font-weight-light">El Collao Ilave</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-2 pb-2 mb-2 d-flex">
        <div class="image" >
          {{-- <img src="{{url('public/dist/img/unaplogo1.png')}}" class="img-circle elevation-2"  alt="Universidad Nacional del Altiplano"> --}}
          <img src="{{ asset('dist/img/iconcollao.png') }}" class="img-circle elevation-2" alt="logo Collao Ilave">

        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          @if (Auth::user()->user_type == 1)
          <li class="nav-item">
            <a href="{{url('admin/dashboard')}}" class="nav-link @if(Request::segment(2) =='dashboard') active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                DNI - PIDE

              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('admin/admin/list')}}" class="nav-link @if(Request::segment(2) =='admin') active @endif">
              <i class="bi bi-hospital"></i>
              <p>
                Admin
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="{{url('admin/estudiante/list')}}" class="nav-link @if(Request::segment(2) =='estudiante') active @endif">
              <i class="bi bi-hospital"></i>
              <p>
                Usuarios
              </p>
            </a>
          </li>
{{--
          <li class="nav-item">
            <a href="{{url('admin/periodo/list')}}" class="nav-link @if(Request::segment(2) =='periodo') active @endif">
              <i class="bi bi-hospital"></i>
              <p>
                Plan de Estudio
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('admin/cursos/list')}}" class="nav-link @if(Request::segment(2) =='cursos') active @endif">
              <i class="bi bi-hospital"></i>
              <p>
                Cursos
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="{{url('admin/periodo_cursos/list')}}" class="nav-link @if(Request::segment(2) =='periodo_cursos') active @endif">
              <i class="bi bi-hospital"></i>
              <p>
                Plan - Cursos
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('admin/inscribir/list')}}" class="nav-link @if(Request::segment(2) =='inscribir') active @endif">
              <i class="bi bi-hospital"></i>
              <p>
                Inscribir - Notas
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('admin/flayer')}}" class="nav-link @if(Request::segment(2) =='images') active @endif">
              <i class="bi bi-hospital"></i>
              <p>
                Subir Flayer
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="{{url('admin/noticias')}}" class="nav-link @if(Request::segment(2) =='noticias') active @endif">
              <i class="bi bi-hospital"></i>
              <p>
                Crear Noticia
              </p>
            </a>
          </li> --}}


          <li class="nav-item">
            <a href="{{url('admin/change_password')}}" class="nav-link @if(Request::segment(2) =='change_password') active @endif">
              <i class="bi bi-hospital"></i>
              <p>
                Cambiar Contraseña
              </p>
            </a>
          </li>



          @elseif (Auth::user()->user_type == 2)
          <li class="nav-item">
           <!-- <a href="{{url('docente/dashboard')}}" class="nav-link @if(Request::segment(2) =='dashboard') active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard

              </p>
            </a>
          </li>-->

          <li class="nav-item">
            <a href="{{url('docente/change_password')}}" class="nav-link @if(Request::segment(2) =='change_password') active @endif">
              <i class="bi bi-hospital"></i>
              <p>
                Cambiar Contraseña
              </p>
            </a>
          </li>

          @elseif (Auth::user()->user_type == 3)
         <li class="nav-item">
            <a href="{{url('estudiante/dashboard')}}" class="nav-link @if(Request::segment(2) =='dashboard') active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                DNI - PIDE

              </p>
            </a>
          </li>

          {{-- <li class="nav-item">
            <a href="{{url('estudiante/notas')}}" class="nav-link @if(Request::segment(2) =='notas') active @endif">
              <i class="bi bi-hospital"></i>
              <p>
                Notas
              </p>
            </a>
          </li> --}}

          <li class="nav-item">
            <a href="{{url('estudiante/change_password')}}" class="nav-link @if(Request::segment(2) =='change_password') active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Cambiar Contraseña
              </p>
            </a>
          </li>

          @endif



          <li class="nav-item">
            <a href="{{url('logout')}}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Salir
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
