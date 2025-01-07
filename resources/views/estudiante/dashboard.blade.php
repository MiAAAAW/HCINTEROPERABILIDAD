@extends('layouts.app') 
{{-- O la plantilla que uses, por ejemplo: layouts.estudiante --}}

@section('content')
<div class="container">
    <h1>Panel de Estudiante</h1>

    {{-- Mensajes de éxito o error (opcional) --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- ========================================================
        FORMULARIO 1: Actualizar Credencial en RENIEC/PIDE
       ======================================================== --}}
    <div class="card mb-4">
        <div class="card-header">
            <h4>Actualizar Credencial PIDE (RENIEC)</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('reniec.actualizar') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="credencialAnterior" class="form-label">Credencial Anterior</label>
                    <input type="text" name="credencialAnterior" id="credencialAnterior" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="credencialNueva" class="form-label">Nueva Credencial</label>
                    <input type="text" name="credencialNueva" id="credencialNueva" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="nuDni" class="form-label">DNI del Usuario</label>
                    <input type="text" name="nuDni" id="nuDni" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="nuRuc" class="form-label">RUC de la Entidad</label>
                    <input type="text" name="nuRuc" id="nuRuc" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Credencial</button>
            </form>
        </div>
    </div>


    {{-- ========================================================
        FORMULARIO 2: Consultar Datos de una Persona por DNI
       ======================================================== --}}
    <div class="card">
        <div class="card-header">
            <h4>Consultar Datos Persona (RENIEC)</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('reniec.consultar') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nuDniConsulta" class="form-label">DNI a Consultar</label>
                    <input type="text" name="nuDniConsulta" id="nuDniConsulta" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="nuDniUsuario" class="form-label">Tu DNI (Usuario Registrado)</label>
                    <input type="text" name="nuDniUsuario" id="nuDniUsuario" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="nuRucUsuario" class="form-label">RUC de la Entidad</label>
                    <input type="text" name="nuRucUsuario" id="nuRucUsuario" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña PIDE (Credencial Nueva)</label>
                    <input type="text" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Consultar Datos</button>
            </form>
        </div>
    </div>

</div>
@endsection




{{-- @extends('layouts.app')

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Consulta de Documento Nacional de Identidad</h1>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Notificaciones de éxito o error -->
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
      <div class="d-flex" style="gap: 20px; align-items: stretch;">
        <!-- Formulario para guardar credenciales -->
        <div class="card" style="flex: 1; min-height: 300px;">
          <div class="card-header">
            <h3 class="card-title">Gestionar Credenciales</h3>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('configurar.credenciales') }}">
              @csrf
              <div class="form-group">
                  <label for="credencial_actual">Credencial Inicial (Proporcionada por RENIEC):</label>
                  <input type="password" id="credencial_actual" name="credencial_actual" class="form-control" required>
              </div>
              <div class="form-group">
                  <label for="nueva_credencial">Nueva Credencial:</label>
                  <input type="password" id="nueva_credencial" name="nueva_credencial" class="form-control" required minlength="8">
              </div>
              <button type="submit" class="btn btn-primary">Actualizar Credencial</button>
          </form>
          </div>
        </div>

        <!-- Formulario para consultar DNI -->
        <div class="card" style="flex: 1; min-height: 300px;">
          <div class="card-header">
            <h3 class="card-title">Consulta de DNI</h3>
          </div>
          <div class="card-body">
            <form action="{{ route('estudiante.consulta.dni.process') }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="dni_consulta">DNI a Consultar</label>
                <input type="text" name="dni_consulta" id="dni_consulta" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary mt-2" style="width: 100%;">Consultar</button>
            </form>
          </div>
        </div>
      </div>

      <!-- Resultados de la consulta -->
      @if (session('data'))
        <div class="card mt-4">
          <div class="card-header">
            <h3 class="card-title">Resultados de la Consulta</h3>
          </div>
          <div class="card-body">
            <ul>
              <li><strong>Primer Apellido:</strong> {{ session('data')['apPrimer'] ?? 'N/A' }}</li>
              <li><strong>Segundo Apellido:</strong> {{ session('data')['apSegundo'] ?? 'N/A' }}</li>
              <li><strong>Nombres:</strong> {{ session('data')['prenombres'] ?? 'N/A' }}</li>
              <li><strong>Estado Civil:</strong> {{ session('data')['estadoCivil'] ?? 'N/A' }}</li>
              <li><strong>Ubigeo:</strong> {{ session('data')['ubigeo'] ?? 'N/A' }}</li>
              <li><strong>Dirección:</strong> {{ session('data')['direccion'] ?? 'N/A' }}</li>
              <li><strong>Restricción:</strong> {{ session('data')['restriccion'] ?? 'N/A' }}</li>
            </ul>
            @if (session('data')['foto'])
              <div>
                <strong>Foto:</strong><br>
                <img src="data:image/jpeg;base64,{{ session('data')['foto'] }}" alt="Foto del DNI" style="max-width: 200px;">
              </div>
            @endif
          </div>
        </div>
      @endif

    </div>
  </section>
</div>

@endsection --}}
