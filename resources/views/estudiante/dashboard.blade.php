@extends('layouts.app')

@section('content')
<div class="content-wrapper"><!-- AdminLTE pattern -->

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

      <!-- Notificaciones de éxito o error (session) -->
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

      <!-- Formularios lado a lado (responsive) -->
      <div class="row" style="gap: 20px; align-items: stretch;">

        <!-- ================================
             1. Formulario ACTUALIZAR (colapsable)
           ================================ -->
        <div class="col-md-6">
          <div class="card" style="min-height: 300px;">

            <!-- Card Header con flecha dinámica -->
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center"
                 data-bs-toggle="collapse"
                 data-bs-target="#collapseActualizar"
                 aria-expanded="true"
                 aria-controls="collapseActualizar"
                 style="cursor: pointer;">
              <h3 class="card-title mb-0">Gestionar Credenciales</h3>
              <i class="fas fa-chevron-up collapse-icon" id="iconActualizar"></i>
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
             2. Formulario CONSULTAR (colapsable)
           ============================ -->
        <div class="col-md-6">
          <div class="card" style="min-height: 300px;">

            <!-- Card Header con flecha dinámica -->
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center"
                 data-bs-toggle="collapse"
                 data-bs-target="#collapseConsultar"
                 aria-expanded="true"
                 aria-controls="collapseConsultar"
                 style="cursor: pointer;">
              <h3 class="card-title mb-0">Consulta de DNI</h3>
              <i class="fas fa-chevron-up collapse-icon" id="iconConsultar"></i>
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
  // Flechas dinámicas para collapse
  const toggleCollapseIcon = (collapseId, iconId) => {
    const collapseElement = document.getElementById(collapseId);
    const iconElement = document.getElementById(iconId);

    collapseElement.addEventListener('show.bs.collapse', () => {
      iconElement.classList.remove('fa-chevron-down');
      iconElement.classList.add('fa-chevron-up');
    });

    collapseElement.addEventListener('hide.bs.collapse', () => {
      iconElement.classList.remove('fa-chevron-up');
      iconElement.classList.add('fa-chevron-down');
    });
  };

  toggleCollapseIcon('collapseActualizar', 'iconActualizar');
  toggleCollapseIcon('collapseConsultar', 'iconConsultar');
});
</script>
@endsection
