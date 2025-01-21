@extends('layouts.app')

@section('content')

    <div class="content-wrapper">

        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="text-purple1">Consulta de RUC - Servicios SUNAT</h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">

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

                <!-- Formulario -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h3 class="card-title mb-0">Consulta de RUC</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ url('/estudiante/ruc/consultar') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="nuRucConsulta">Número de RUC:</label>
                                        <input type="text" id="nuRucConsulta" name="ruc" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2 w-100">Consultar</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Resultados -->
                    @if (isset($results))
                        <div class="col-md-12 mt-4">
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h3 class="card-title mb-0">Resultados para el RUC: {{ $ruc }}</h3>
                                </div>
                                <div class="card-body">
                                    <!-- Resultados detallados -->
                                    @foreach ($results as $service => $result)
                                        <div class="mt-4">
                                            <h5 class="text-secondary">{{ $service }}</h5>
                                            @if (isset($result['error']) && $result['error'])
                                                <p class="text-danger">Error: {{ $result['message'] }}</p>
                                            @else
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Campo</th>
                                                            <th>Valor</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($result as $key => $value)
                                                            @if (!is_array($value)) <!-- Ignorar arrays anidados -->
                                                                <tr>
                                                                    <td>{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                                                    <td>{{ $value }}</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>

@endsection
