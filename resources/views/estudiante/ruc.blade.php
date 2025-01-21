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

            <!-- Formulario de consulta -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Consultar RUC</h3>
                </div>
                <form action="{{ route('estudiante.ruc.consultar') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="ruc">Número de RUC</label>
                            <input type="text" name="ruc" id="ruc" class="form-control" placeholder="Ingrese el número de RUC" required>
                        </div>
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Consultar</button>
                    </div>
                </form>
            </div>

            <!-- Resultados -->
            @if(isset($results))
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Resultados de la Consulta</h3>
                    </div>
                    <div class="card-body">
                        @foreach($results as $key => $result)
                            <h4 class="text-info">{{ ucfirst($key) }}</h4>
                            @if(isset($result['error']) && $result['error'])
                                <div class="alert alert-danger">
                                    <p>{{ $result['message'] }}</p>
                                </div>
                            @else
                                <pre>{{ json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

</div>

@endsection
