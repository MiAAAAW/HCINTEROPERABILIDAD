<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta RUC - SUNAT</title>
</head>
<body>
    <h1>Consulta RUC - Servicios SUNAT</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/estudiante/ruc/consultar') }}" method="POST">
        @csrf
        <label for="ruc">Número de RUC:</label>
        <input type="text" id="ruc" name="ruc" value="{{ old('ruc') }}" required>
        <br>

        <label for="service">Seleccionar Servicio:</label>
        <select id="service" name="service">
            <option value="getDatosPrincipales" {{ old('service') == 'getDatosPrincipales' ? 'selected' : '' }}>Datos Principales</option>
            <option value="getDatosSecundarios" {{ old('service') == 'getDatosSecundarios' ? 'selected' : '' }}>Datos Secundarios</option>
            <option value="getDomicilioLegal" {{ old('service') == 'getDomicilioLegal' ? 'selected' : '' }}>Domicilio Legal</option>
            <option value="getEstablecimientosAnexos" {{ old('service') == 'getEstablecimientosAnexos' ? 'selected' : '' }}>Establecimientos Anexos</option>
        </select>
        <br>
        <button type="submit">Consultar</button>
    </form>

    @if (isset($result))
        <h2>Resultados para el RUC: {{ $ruc }}</h2>
        <h3>Servicio Consultado: {{ $service }}</h3>
        <pre>{{ json_encode($result, JSON_PRETTY_PRINT) }}</pre>
    @endif
</body>
</html>
