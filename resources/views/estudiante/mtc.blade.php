@extends('layouts.app')

@section('content')
<div class="content-wrapper">

    <!-- Encabezado -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-purple1 text-center fw-bold w-100">
                        Información de Consulta del Record de Conductor
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Contenido principal -->
    <section class="content">
        <div class="container-fluid">

            <!-- Formulario -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Formulario de Consulta</h3>
                </div>
                <form id="form-consulta" action="{{ url('/estudiante/mtc') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-row row">
                            <div class="form-group col-md-5">
                                <label for="tipo">Tipo de Documento</label>
                                <select name="tipo" id="tipo" class="form-control">
                                    <option value="2">DNI</option>
                                    <option value="1">Carnet de Extranjería</option>
                                </select>
                            </div>

                            <div class="form-group col-md-5">
                                <label for="dni">Número de Documento</label>
                                <input type="text" name="dni" id="dni" class="form-control" placeholder="Ingrese el número" required>
                            </div>

                            <div class="form-group col-md-2 d-flex align-items-end justify-content-center mt-2">
                                <button id="btn-consultar" type="submit" class="btn btn-primary fw-bold px-4 py-2" style="max-width: 250px;">
                                    <span class="spinner-border spinner-border-sm me-1 d-none" role="status" aria-hidden="true"></span>
                                        Consultar
                                </button>
                            </div>

                        </div>

                        <div class="text-center mt-2">
                            <button type="button" id="btn-nueva" class="btn btn-warning fw-bold px-4 py-2" style="max-width: 250px;" disabled>
                                Nueva Consulta
                            </button>
                        </div>
                    </div>
                </form>
            </div>


            @if(isset($dni) && isset($tipo))
                <div class="text-center my-4 resultado-consulta">
                    <p style="font-weight: bold; font-size: 1.1rem;">CONSULTA REALIZADA PARA:</p>
                    <p>
                        <strong>Tipo de Documento:</strong> {{ $tipo == 2 ? 'DNI' : 'Carnet de Extranjería' }}<br>
                        <strong>Número de Docuemto:</strong> {{ $dni }}
                    </p>
                </div>
            @endif



        <!-- Resultados -->
        @if(isset($licenciaData) || isset($sancionesData))
            <div class="row">
                {{-- Licencia --}}
                @isset($licenciaData)
                    <div class="col-md-6">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title text-center w-100" style="font-weight: bold;" > Última Licencia</h3>
                            </div>
                            <div class="card-body">
                                @php
                                    $licencia = $licenciaData['GetDatosUltimaLicenciaMTCResponse']['GetDatosUltimaLicenciaMTCResult']['diffgram']['NewDataSet']['Table'] ?? null;
                                @endphp
                                @if($licencia)
                                <div class="row">
                                    <div class="col-5"><strong>Nombres:</strong></div>
                                    <div class="col-7">{{ $licencia['NOMBRE'] }} {{ $licencia['APE_PATERNO'] }} {{ $licencia['APE_MATERNO'] }}</div>

                                    <div class="col-5"><strong>N° Licencia:</strong></div>
                                    <div class="col-7">{{ $licencia['NUM_LICENCIA'] }}</div>

                                    <div class="col-5"><strong>Categoría:</strong></div>
                                    <div class="col-7">{{ $licencia['CATEGORIA'] }}</div>

                                    <div class="col-5"><strong>Expedición:</strong></div>
                                    <div class="col-7">{{ $licencia['FECEXP'] }}</div>

                                    <div class="col-5"><strong>Revalidación:</strong></div>
                                    <div class="col-7">{{ $licencia['FECREV'] }}</div>

                                    <div class="col-5"><strong>Estado:</strong></div>
                                    <div class="col-7">{{ $licencia['ESTADO'] }}</div>

                                    <div class="col-5"><strong>Restricción:</strong></div>
                                    <div class="col-7">{{ $licencia['RESTRICCION'] }}</div>
                                </div>

                                @else
                                    <p>No se encontró información de licencia.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endisset

                {{-- Sanciones --}}
                @isset($sancionesData)
                    <div class="col-md-6">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title text-center w-100" style="font-weight: bold;">Últimas Sanciones</h3>
                            </div>
                            <div class="card-body">
                                @php
                                    $sancion = $sancionesData['GetDatosUltimasSancionesMTCResponse']['GetDatosUltimasSancionesMTCResult']['diffgram']['DocumentElement']['dt']['dc'] ?? null;
                                @endphp

                                @if($sancion)
                                    <p>{{ $sancion }}</p>
                                @else
                                    <p>No se encontraron sanciones.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endisset
            </div>
        @endif

        {{-- Papeletas --}}
        @isset($papeletasData)
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title text-center w-100" style="font-weight: bold;">Papeletas</h3>
                </div>
                <div class="card-body">
                    @php
                        $papeletas = $papeletasData['GetDatosPapeletasMTCResponse']['GetDatosPapeletasMTCResult']['diffgram']['NewDataSet']['Table'] ?? null;
                        $papeletas = is_array($papeletas) && isset($papeletas[0]) ? $papeletas : ($papeletas ? [$papeletas] : []);
                    @endphp

                    @if(count($papeletas))
                        <div class="table-responsive">
                        <table class="table table-bordered table-sm small align-middle">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th style="white-space: nowrap;">CÓDIGO ADMINISTRADO</th>
                                    <th style="white-space: nowrap;">NÚMERO INFRACCIÓN</th>
                                    <th style="white-space: nowrap;">CÓDIGO ENTIDAD</th>
                                    <th style="white-space: nowrap;">ENTIDAD</th>
                                    <th>PAPELETA</th>
                                    <th>FALTA</th>
                                    <th style="white-space: nowrap;">FECHA INFRACCIÓN</th>
                                    <th>PUNTOS FIRMES</th>
                                    <th>EN PROCESO</th>
                                    <th>ESTADO</th>
                                    <th>TIPO PIT</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($papeletas as $fila)
                                    <tr>
                                        <td>{{ $fila['COD_ADMINISTRADO'] ?? '-' }}</td>
                                        <td>{{ $fila['NUM_INFRACCION'] ?? '-' }}</td>
                                        <td>{{ $fila['COD_ENTIDAD'] ?? '-' }}</td>
                                        <td>{{ $fila['ENTIDAD'] ?? '-' }}</td>
                                        <td>{{ $fila['PAPELETA'] ?? '-' }}</td>
                                        <td>{{ $fila['FALTA'] ?? '-' }}</td>
                                        <td>{{ $fila['FEC_INFRACCION'] ?? '-' }}</td>
                                        <td>{{ $fila['PUNTOS_x0020_FIRMES'] ?? '-' }}</td>
                                        <td>{{ $fila['P._x0020_PROCESO'] ?? '-' }}</td>
                                        <td>{{ $fila['ESTADO'] ?? '-' }}</td>
                                        <td>{{ $fila['TIPOPIT'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    @else
                        <p>No se encontraron papeletas.</p>
                    @endif
                </div>
            </div>
        @endisset
        @if(isset($dni) && isset($tipo))
            <div id="exportar-section" class="text-center mt-4">
                <form action="{{ route('estudiante.mtc.exportar') }}" method="POST" target="_blank">
                    @csrf
                    <input type="hidden" name="tipo" value="{{ $tipo }}">
                    <input type="hidden" name="dni" value="{{ $dni }}">
                    <button type="submit" class="btn btn-outline-danger fw-bold">
                        📄 Exportar PDF
                    </button>
                </form>
            </div>
        @endif



    </section>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const tipoSelect = document.getElementById('tipo');
    const dniInput = document.getElementById('dni');
    const btnConsultar = document.getElementById('btn-consultar');
    const spinner = btnConsultar.querySelector('.spinner-border');
    const originalText = btnConsultar.innerHTML; // guarda el texto original

    const advertencia = document.createElement('div');
    advertencia.classList.add('alert', 'alert-warning', 'mt-2');
    advertencia.style.display = 'none';
    advertencia.innerText = 'Parece que ingresaste un DNI pero seleccionaste Carnet de Extranjería. Corrige uno de los campos.';
    dniInput.parentNode.appendChild(advertencia);

    form.addEventListener('submit', function (e) {
        const tipo = tipoSelect.value;
        const numero = dniInput.value.trim();

        if (tipo === '1' && numero.length === 8 && /^[0-9]+$/.test(numero)) {
            e.preventDefault();
            advertencia.style.display = 'block';
        } else {
            advertencia.style.display = 'none';
            spinner.classList.remove('d-none'); // Mostrar spinner
            btnConsultar.disabled = true;       // Evita doble envío
            btnConsultar.innerHTML = `<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Consultando...`;
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnNueva = document.getElementById('btn-nueva');
    const resultadoSecciones = document.querySelectorAll('.card-success, .card-warning, .card-danger, .alert-info, .resultado-consulta');
    const exportarSection = document.getElementById('exportar-section');

    // Cuando se presiona "Nueva Consulta"
    btnNueva.addEventListener('click', function () {
        // Oculta resultados
        resultadoSecciones.forEach(sec => sec.style.display = 'none');

        // Oculta sección del botón PDF si existe
        if (exportarSection) {
            exportarSection.style.display = 'none';
        }

        // Limpia formulario
        document.getElementById('dni').value = '';
        document.getElementById('tipo').value = '2';
        document.getElementById('dni').focus();

        // Desactiva botón
        btnNueva.disabled = true;
        btnNueva.classList.remove('btn-warning');
        btnNueva.classList.add('btn-secondary');
    });

    // Si hay resultados al cargar, activar el botón
    if (resultadoSecciones.length > 0) {
        btnNueva.disabled = false;
        btnNueva.classList.remove('btn-secondary');
        btnNueva.classList.add('btn-warning');
    }
});
</script>




@endsection
