<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Record del Conductor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            color: rgb(30, 34, 95);
            margin-bottom: 10px;
        }

        .section {
            margin-top: 20px;
        }

        .section h4 {
            background-color: rgb(11, 29, 113);
            color: white;
            padding: 6px;
            margin: 0 0 10px 0;
        }

        .info {
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th, td {
            border: 1px solid #999;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #e0e0e0;
        }

        .sin-datos {
            font-style: italic;
            color: #555;
        }
    </style>
</head>
<body>

    <img src="{{ public_path('encabezado.png') }}" style="width: 100%; margin-bottom: 10px;">

    <h2>RECORD DE CONDUCTOR</h2>

    <p><strong>Tipo de Documento:</strong> {{ $tipo == 2 ? 'DNI' : 'Carnet de Extranjería' }}</p>
    <p><strong>Número:</strong> {{ $dni }}</p>

    {{-- LICENCIA --}}
    <div class="section">
        <h4>Última Licencia</h4>
        @php
            $licencia = $licenciaData['GetDatosUltimaLicenciaMTCResponse']['GetDatosUltimaLicenciaMTCResult']['diffgram']['NewDataSet']['Table'] ?? null;
        @endphp

        @if($licencia)
            <div class="info"><strong>Nombres:</strong> {{ $licencia['NOMBRE'] }} {{ $licencia['APE_PATERNO'] }} {{ $licencia['APE_MATERNO'] }}</div>
            <div class="info"><strong>N° Licencia:</strong> {{ $licencia['NUM_LICENCIA'] }}</div>
            <div class="info"><strong>Categoría:</strong> {{ $licencia['CATEGORIA'] }}</div>
            <div class="info"><strong>Expedición:</strong> {{ $licencia['FECEXP'] }}</div>
            <div class="info"><strong>Revalidación:</strong> {{ $licencia['FECREV'] }}</div>
            <div class="info"><strong>Estado:</strong> {{ $licencia['ESTADO'] }}</div>
            <div class="info"><strong>Restricción:</strong> {{ $licencia['RESTRICCION'] }}</div>
        @else
            <p class="sin-datos">No se encontró información de licencia.</p>
        @endif
    </div>

    {{-- PAPELETAS --}}
    <div class="section">
        <h4>Papeletas</h4>
        @php
            $papeletas = $papeletasData['GetDatosPapeletasMTCResponse']['GetDatosPapeletasMTCResult']['diffgram']['NewDataSet']['Table'] ?? null;
            $papeletas = is_array($papeletas) && isset($papeletas[0]) ? $papeletas : ($papeletas ? [$papeletas] : []);
        @endphp

        @if(count($papeletas))
            <table style="font-size: 10px;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cod. Administrado</th>
                        <th>N° Infracción</th>
                        <th>Cod. Entidad</th>
                        <th>Entidad</th>
                        <th>Papeleta</th>
                        <th>Fecha Infracción</th>
                        <th>Falta</th>
                        <th>Puntos</th>
                        <th>Proceso</th>
                        <th>Estado</th>
                        <th>Tipo PIT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($papeletas as $i => $fila)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $fila['COD_ADMINISTRADO'] ?? '-' }}</td>
                            <td>{{ $fila['NUM_INFRACCION'] ?? '-' }}</td>
                            <td>{{ $fila['COD_ENTIDAD'] ?? '-' }}</td>
                            <td>{{ $fila['ENTIDAD'] ?? '-' }}</td>
                            <td>{{ $fila['PAPELETA'] ?? '-' }}</td>
                            <td>{{ $fila['FEC_INFRACCION'] ?? '-' }}</td>
                            <td>{{ $fila['FALTA'] ?? '-' }}</td>
                            <td>{{ $fila['PUNTOS_x0020_FIRMES'] ?? '-' }}</td>
                            <td>{{ $fila['P._x0020_PROCESO'] ?? '-' }}</td>
                            <td>{{ $fila['ESTADO'] ?? '-' }}</td>
                            <td>{{ $fila['TIPOPIT'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="sin-datos">No se encontraron papeletas.</p>
        @endif
    </div>

    {{-- SANCIONES --}}
    <div class="section">
        <h4>Últimas Sanciones</h4>
        @php
            $sancion = $sancionesData['GetDatosUltimasSancionesMTCResponse']['GetDatosUltimasSancionesMTCResult']['diffgram']['DocumentElement']['dt']['dc'] ?? null;
        @endphp

        @if($sancion)
            <p>{{ $sancion }}</p>
        @else
            <p class="sin-datos">El administrado no posee sanciones.</p>
        @endif
    </div>

</body>
</html>
