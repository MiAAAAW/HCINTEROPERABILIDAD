@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-purple1">PIDE - Ministerio de Justicia - Servicios Registro Nacional de Abogados</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Mensajes de error -->
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Muestra la respuesta global (si se han consultado todas las funciones) -->
            @if(session('allResponses') && session('endpointName'))
                @php
                    $allResponses = session('allResponses');
                @endphp

                <div class="alert alert-info">
                    <h5>Respuesta de {{ session('endpointName') }}</h5>
                </div>

                <!-- EJEMPLO: Parseo de SancionDocumento (búsqueda por DNI) -->
                @if(isset($allResponses['SancionDocumento']['return']))
                    @php
                        // Podría ser un solo objeto o un array de sanciones
                        $sancionDoc = $allResponses['SancionDocumento']['return'];
                        if(isset($sancionDoc['abogadoColegiado'])) {
                            // Convierto en array para iterar
                            $sancionDoc = [$sancionDoc];
                        }
                    @endphp

                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <strong>SancionDocumento - Resultados</strong>
                        </div>
                        <div class="card-body">
                            @foreach($sancionDoc as $item)
                                <div class="border p-2 mb-3">
                                    <h5>Datos del Abogado</h5>
                                    <p><strong>Apellido Paterno:</strong> {{ $item['abogadoColegiado']['apePaterno'] ?? '' }}</p>
                                    <p><strong>Apellido Materno:</strong> {{ $item['abogadoColegiado']['apeMaterno'] ?? '' }}</p>
                                    <p><strong>Nombres:</strong> {{ $item['abogadoColegiado']['nombres'] ?? '' }}</p>
                                    <p><strong>Número de Documento:</strong> {{ $item['abogadoColegiado']['numeroDocumento'] ?? '' }}</p>
                                    <p><strong>Sexo:</strong> {{ $item['abogadoColegiado']['sexo'] ?? '' }}</p>

                                    <h5>Datos de la Sanción</h5>
                                    <p><strong>Estado:</strong> {{ $item['estado'] ?? '' }}</p>
                                    <p><strong>Tipo de Sanción:</strong> {{ $item['tipoSancion']['nombre'] ?? '' }}</p>
                                    <p><strong>Fecha de Emisión:</strong> {{ $item['fechaEmision'] ?? '' }}</p>
                                    <p><strong>Fecha de Inicio:</strong> {{ $item['fechaInicio'] ?? '' }}</p>
                                    <p><strong>Número de Expediente:</strong> {{ $item['numeroExpediente'] ?? '' }}</p>

                                    <h5>Entidad Sancionadora</h5>
                                    <p><strong>Nombre:</strong> {{ $item['entidadSancionadora']['nombre'] ?? '' }}</p>
                                    <p><strong>Sigla:</strong> {{ $item['entidadSancionadora']['sigla'] ?? '' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- EJEMPLO: Parseo de SancionColegiatura -->
                @if(isset($allResponses['SancionColegiatura']['return']))
                    @php
                        $sancionCol = $allResponses['SancionColegiatura']['return'];
                        if(isset($sancionCol['abogadoColegiado'])) {
                            $sancionCol = [$sancionCol];
                        }
                    @endphp

                    <div class="card mb-3">
                        <div class="card-header bg-success text-white">
                            <strong>SancionColegiatura - Resultados</strong>
                        </div>
                        <div class="card-body">
                            @foreach($sancionCol as $item)
                                <div class="border p-2 mb-3">
                                    <h5>Abogado</h5>
                                    <p><strong>Apellidos:</strong> {{ ($item['abogadoColegiado']['apePaterno'] ?? '').' '.($item['abogadoColegiado']['apeMaterno'] ?? '') }}</p>
                                    <p><strong>Nombres:</strong> {{ $item['abogadoColegiado']['nombres'] ?? '' }}</p>
                                    <p><strong>Número de Documento:</strong> {{ $item['abogadoColegiado']['numeroDocumento'] ?? '' }}</p>

                                    <h5>Datos de la Sanción</h5>
                                    <p><strong>Estado:</strong> {{ $item['estado'] ?? '' }}</p>
                                    <p><strong>Tipo de Sanción:</strong> {{ $item['tipoSancion']['nombre'] ?? '' }}</p>
                                    <p><strong>Fecha de Inicio:</strong> {{ $item['fechaInicio'] ?? '' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Muestras rápidas para los demás endpoints (ej. ColegioAbogado) -->
                @if(isset($allResponses['ColegioAbogado']['return']))
                    @php
                        $colegios = $allResponses['ColegioAbogado']['return'];
                        if(isset($colegios['codigo'])) {
                            $colegios = [$colegios];
                        }
                    @endphp

                    <div class="card mb-3">
                        <div class="card-header bg-secondary text-white">
                            <strong>ColegioAbogado</strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Sigla</th>
                                        <th>Vigente</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($colegios as $colegio)
                                    <tr>
                                        <td>{{ $colegio['codigo'] ?? '' }}</td>
                                        <td>{{ $colegio['nombre'] ?? '' }}</td>
                                        <td>{{ $colegio['sigla'] ?? '' }}</td>
                                        <td>{{ $colegio['vigente'] ?? '' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <!-- Repite lógicas similares para EntidadSancionadora, TipoDocumento y TipoSanciones -->
                <!-- ... -->
            @endif

            <!-- Card con el Formulario Único -->
            <div class="card">
                <div class="card-header">
                    <h4>Ingrese Credenciales y Parámetros</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('estudiante.minjus.consultAll') }}" method="POST">
                        @csrf
                        <!-- Credenciales -->
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
                        <!-- Ejemplo: SancionColegiatura -->
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="colegioId">Colegio ID</label>
                                <input type="text" class="form-control" id="colegioId" name="colegioId" placeholder="Ej: 1">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="colegiatura">Colegiatura</label>
                                <input type="text" class="form-control" id="colegiatura" name="colegiatura" placeholder="Ej: 38409">
                            </div>
                        </div>
                        <!-- Ejemplo: SancionDocumento -->
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="tipoDocumento">Tipo de Documento</label>
                                <input type="text" class="form-control" id="tipoDocumento" name="tipoDocumento" placeholder="Ej: DNI">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="numeroDocumento">Número de Documento</label>
                                <input type="text" class="form-control" id="numeroDocumento" name="numeroDocumento" placeholder="Ej: 12345678">
                            </div>
                        </div>
                        <!-- Ejemplo: SancionNombre -->
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="apePaterno">Apellido Paterno</label>
                                <input type="text" class="form-control" id="apePaterno" name="apePaterno" placeholder="Ej: Pérez">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="apeMaterno">Apellido Materno</label>
                                <input type="text" class="form-control" id="apeMaterno" name="apeMaterno" placeholder="Ej: Gómez">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="nombres">Nombres</label>
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
    // Mostrar/Ocultar contraseña con jQuery y Font Awesome
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
