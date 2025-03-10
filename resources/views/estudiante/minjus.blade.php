@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Encabezado -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="text-purple1">PIDE - Ministerio de Justicia - Servicios Registro Nacional de Abogados</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Contenido principal -->
    <section class="content">
        <div class="container-fluid">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if(session('allResponses') && session('endpointName'))
                <div class="alert alert-info">
                    <h5>Respuesta de {{ session('endpointName') }}</h5>
                    <pre>{{ json_encode(session('allResponses'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4>Ingrese Credenciales y Parámetros</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('estudiante.minjus.consultAll') }}" method="POST">
                        @csrf

                        <!-- Credenciales (MINJUS) -->
                        <div class="form-group">
                            <label for="user">Usuario (MINJUS)</label>
                            <input type="text" class="form-control" id="user" name="user" placeholder="Ingrese su usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="pass">Contraseña (MINJUS)</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="pass" name="pass" placeholder="Ingrese su contraseña" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h5>Parámetros Opcionales</h5>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="colegioId">Colegio ID (SancionColegiatura)</label>
                                <input type="text" class="form-control" id="colegioId" name="colegioId" placeholder="Ej: 1">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="colegiatura">Colegiatura (SancionColegiatura)</label>
                                <input type="text" class="form-control" id="colegiatura" name="colegiatura" placeholder="Ej: 38409">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="tipoDocumento">Tipo de Documento (SancionDocumento)</label>
                                <input type="text" class="form-control" id="tipoDocumento" name="tipoDocumento" placeholder="Ej: DNI">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="numeroDocumento">Número de Documento (SancionDocumento)</label>
                                <input type="text" class="form-control" id="numeroDocumento" name="numeroDocumento" placeholder="Ej: 12345678">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="apePaterno">Apellido Paterno (SancionNombre)</label>
                                <input type="text" class="form-control" id="apePaterno" name="apePaterno" placeholder="Ej: Pérez">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="apeMaterno">Apellido Materno (SancionNombre)</label>
                                <input type="text" class="form-control" id="apeMaterno" name="apeMaterno" placeholder="Ej: Gómez">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="nombres">Nombres (SancionNombre)</label>
                                <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Ej: Juan">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Recuperar Archivo</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="recuperarArchivo" id="recuperarTrue" value="true">
                                <label class="form-check-label" for="recuperarTrue">True</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="recuperarArchivo" id="recuperarFalse" value="false" checked>
                                <label class="form-check-label" for="recuperarFalse">False</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-block">Ejecutar Todas las Consultas</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script>
    // Mostrar/Ocultar contraseña usando jQuery y Font Awesome
    $(document).ready(function() {
        $('.toggle-password').on('click', function() {
            let passInput = $('#pass');
            let icon = $(this).find('i');

            if (passInput.attr('type') === 'password') {
                passInput.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passInput.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    });
</script>
@endsection
