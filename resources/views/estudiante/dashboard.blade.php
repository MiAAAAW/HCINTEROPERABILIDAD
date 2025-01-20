@extends('layouts.app')

@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Consulta y Actualización de Credenciales (RENIEC - PIDE)</h1>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container">

      <!-- Notificaciones de éxito o error de Laravel (session) -->
      @if (session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

      @if ($errors->any())
        <div class="alert alert-danger">
          {{ $errors->first() }}
        </div>
      @endif

      <!-- Formularios lado a lado -->
      <div class="row" style="gap: 20px; align-items: stretch;">

        <!-- ================================
             1. Formulario ACTUALIZAR
           ================================ -->
        <div class="col-md-6">
          <div class="card" style="min-height: 300px;">

            <!-- Header con indicador de colapsar -->
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center"
                 data-toggle="collapse"
                 data-target="#collapseActualizar"
                 aria-expanded="true"
                 aria-controls="collapseActualizar"
                 style="cursor: pointer;">
              <h3 class="card-title">Gestionar Credenciales</h3>
              <i class="fas fa-chevron-up" id="iconActualizar"></i>
            </div>

            <!-- Contenedor colapsable -->
            <div id="collapseActualizar" class="collapse show">
              <div class="card-body">
                <form id="frmActualizar" onsubmit="return false;">
                  @csrf

                  <!-- Credencial Actual -->
                  <div class="form-group" style="position: relative;">
                    <label for="credencialAnterior">Credencial Actual:</label>
                    <input
                      type="password"
                      id="credencialAnterior"
                      name="credencialAnterior"
                      class="form-control"
                      required
                    >
                    <i
                      class="fas fa-eye"
                      id="toggleCredAnterior"
                      style="position: absolute; top: 35px; right: 15px; cursor: pointer;">
                    </i>
                  </div>

                  <!-- Nueva Credencial -->
                  <div class="form-group" style="position: relative;">
                    <label for="credencialNueva">Nueva Credencial:</label>
                    <input
                      type="password"
                      id="credencialNueva"
                      name="credencialNueva"
                      class="form-control"
                      required
                      minlength="8"
                    >
                    <i
                      class="fas fa-eye"
                      id="toggleCredNueva"
                      style="position: absolute; top: 35px; right: 15px; cursor: pointer;">
                    </i>
                  </div>

                  <!-- DNI -->
                  <div class="form-group">
                    <label for="nuDni">DNI (Usuario):</label>
                    <input
                      type="text"
                      id="nuDni"
                      name="nuDni"
                      class="form-control"
                      required
                    >
                  </div>

                  <!-- RUC -->
                  <div class="form-group">
                    <label for="nuRuc">RUC de la Entidad:</label>
                    <input
                      type="text"
                      id="nuRuc"
                      name="nuRuc"
                      class="form-control"
                      required
                      value="20181438364"
                    >
                  </div>

                  <button
                    type="submit"
                    class="btn btn-primary mt-2 w-100"
                  >
                    Actualizar Credencial
                  </button>
                </form>

                <!-- Resultado de actualizar -->
                <div id="resultadoActualizar" class="mt-3"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- ============================
             2. Formulario CONSULTAR
           ============================ -->
        <div class="col-md-6">
          <div class="card" style="min-height: 300px;">

            <!-- Header con indicador de colapsar -->
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center"
                 data-toggle="collapse"
                 data-target="#collapseConsultar"
                 aria-expanded="true"
                 aria-controls="collapseConsultar"
                 style="cursor: pointer;">
              <h3 class="card-title">Consulta de DNI</h3>
              <i class="fas fa-chevron-up" id="iconConsultar"></i>
            </div>

            <!-- Contenedor colapsable -->
            <div id="collapseConsultar" class="collapse show">
              <div class="card-body">
                <form id="frmConsultar" onsubmit="return false;">
                  @csrf

                  <div class="form-group">
                    <label for="nuDniConsulta">DNI a Consultar:</label>
                    <input
                      type="text"
                      id="nuDniConsulta"
                      name="nuDniConsulta"
                      class="form-control"
                      required
                    >
                  </div>

                  <div class="form-group">
                    <label for="nuDniUsuario">Tu DNI (Usuario):</label>
                    <input
                      type="text"
                      id="nuDniUsuario"
                      name="nuDniUsuario"
                      class="form-control"
                      required
                    >
                  </div>

                  <div class="form-group">
                    <label for="nuRucUsuario">RUC de la Entidad:</label>
                    <input
                      type="text"
                      id="nuRucUsuario"
                      name="nuRucUsuario"
                      class="form-control"
                      required
                      value="20181438364"
                    >
                  </div>

                  <div class="form-group" style="position: relative;">
                    <label for="password">Contraseña PIDE:</label>
                    <input
                      type="password"
                      id="password"
                      name="password"
                      class="form-control"
                      required
                    >
                    <i
                      class="fas fa-eye"
                      id="togglePasswordPIDE"
                      style="position: absolute; top: 35px; right: 15px; cursor: pointer;">
                    </i>
                  </div>

                  <button
                    type="submit"
                    class="btn btn-success mt-2 w-100"
                  >
                    Consultar
                  </button>
                </form>

                <!-- Resultado de consulta -->
                <div id="resultadoConsulta" class="mt-3"></div>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.row -->
    </div><!-- /.container -->
  </section>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // =======================================
  // Actualizar íconos de colapso
  // =======================================
  const collapseActualizar = document.getElementById('collapseActualizar');
  const collapseConsultar = document.getElementById('collapseConsultar');

  const iconActualizar = document.getElementById('iconActualizar');
  const iconConsultar = document.getElementById('iconConsultar');

  collapseActualizar.addEventListener('show.bs.collapse', () => {
    iconActualizar.classList.remove('fa-chevron-down');
    iconActualizar.classList.add('fa-chevron-up');
  });

  collapseActualizar.addEventListener('hide.bs.collapse', () => {
    iconActualizar.classList.remove('fa-chevron-up');
    iconActualizar.classList.add('fa-chevron-down');
  });

  collapseConsultar.addEventListener('show.bs.collapse', () => {
    iconConsultar.classList.remove('fa-chevron-down');
    iconConsultar.classList.add('fa-chevron-up');
  });

  collapseConsultar.addEventListener('hide.bs.collapse', () => {
    iconConsultar.classList.remove('fa-chevron-up');
    iconConsultar.classList.add('fa-chevron-down');
  });
});
</script>
@endsection
