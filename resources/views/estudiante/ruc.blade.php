@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mt-4">Consulta RUC - Servicios SUNAT</h1>

    <!-- Mostrar errores -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulario -->
    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ url('/estudiante/ruc/consultar') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="ruc" class="form-label">Número de RUC:</label>
                    <input type="text" id="ruc" name="ruc" class="form-control" value="{{ old('ruc') }}" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Consultar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Mostrar resultados -->
    @if (isset($results))
        <div class="mt-4">
            <h2>Resultados para el RUC: {{ $ruc }}</h2>

            @foreach ($results as $service => $result)
                <div class="card mt-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">{{ $service }}</h5>
                    </div>
                    <div class="card-body">
                        @if (isset($result['error']) && $result['error'])
                            <p class="text-danger">Error: {{ $result['message'] }}</p>
                        @else
                            <pre>{{ json_encode($result, JSON_PRETTY_PRINT) }}</pre>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
