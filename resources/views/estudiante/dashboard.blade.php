@extends('layouts.app')

@section('content')

<div class="content-wrapper"><!-- Ajusta el espaciado general -->

    <!-- Content Header -->
    <div class="content-header">
        <div class="container">
        <div class="row mb-2">
            <div class="col-sm-12">
            <h1 class="m-0">Consulta y Actualización de Credenciales (RENIEC - PIDE)</h1>
            </div>
        </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="container">

        <!-- Notificaciones -->
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

            <!-- Formulario ACTUALIZAR -->
            <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center"
                    onclick="toggleCollapse('collapseActualizar', 'iconActualizar')"
                    style="cursor: pointer;">
                <h3 class="card-title">Gestionar Credenciales</h3>
                <i id="iconActualizar" class="fas fa-chevron-up toggle-icon"></i>
                </div>
                <div id="collapseActualizar" class="collapse show">
                <div class="card-body">
                    <form id="frmActualizar" onsubmit="return false;">
                    @csrf
                    <div class="form-group" style="position: relative;">
                        <label for="credencialAnterior">Credencial Actual:</label>
                        <input type="password" id="credencialAnterior" name="credencialAnterior" class="form-control" required>
                        <i class="fas fa-eye" id="toggleCredAnterior" style="position: absolute; top: 35px; right: 15px; cursor: pointer;"></i>
                    </div>
                    <div class="form-group" style="position: relative;">
                        <label for="credencialNueva">Nueva Credencial:</label>
                        <input type="password" id="credencialNueva" name="credencialNueva" class="form-control" required minlength="8">
                        <i class="fas fa-eye" id="toggleCredNueva" style="position: absolute; top: 35px; right: 15px; cursor: pointer;"></i>
                    </div>
                    <div class="form-group">
                        <label for="nuDni">DNI (Usuario):</label>
                        <input type="text" id="nuDni" name="nuDni" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nuRuc">RUC de la Entidad:</label>
                        <input type="text" id="nuRuc" name="nuRuc" class="form-control" required value="20181438364">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2 w-100">Actualizar Credencial</button>
                    </form>
                    <div id="resultadoActualizar" class="mt-3"></div>
                </div>
                </div>
            </div>
            </div>

            <!-- Formulario CONSULTAR -->
            <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center"
                    onclick="toggleCollapse('collapseConsultar', 'iconConsultar')"
                    style="cursor: pointer;">
                <h3 class="card-title">Consulta de DNI</h3>
                <i id="iconConsultar" class="fas fa-chevron-up toggle-icon"></i>
                </div>
                <div id="collapseConsultar" class="collapse show">
                <div class="card-body">
                    <form id="frmConsultar" onsubmit="return false;">
                    @csrf
                    <div class="form-group">
                        <label for="nuDniConsulta">DNI a Consultar:</label>
                        <input type="text" id="nuDniConsulta" name="nuDniConsulta" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nuDniUsuario">Tu DNI (Usuario):</label>
                        <input type="text" id="nuDniUsuario" name="nuDniUsuario" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nuRucUsuario">RUC de la Entidad:</label>
                        <input type="text" id="nuRucUsuario" name="nuRucUsuario" class="form-control" required value="20181438364">
                    </div>
                    <div class="form-group" style="position: relative;">
                        <label for="password">Contraseña PIDE:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                        <i class="fas fa-eye" id="togglePasswordPIDE" style="position: absolute; top: 35px; right: 15px; cursor: pointer;"></i>
                    </div>
                    <button type="submit" class="btn btn-success mt-2 w-100">Consultar</button>
                    </form>
                    <div id="resultadoConsulta" class="mt-3"></div>
                </div>
                </div>
            </div>
            </div>

        </div>
        </div>
    </section>
</div>


@endsection

