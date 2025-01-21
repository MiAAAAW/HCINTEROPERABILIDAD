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
                            <input type="text" name="ruc" id="ruc" class="form-control" placeholder="Ingrese el número de RUC" value="{{ old('ruc') }}" required>
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
                <div class="card card-success mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Resultados de la Consulta</h3>
                    </div>
                    <div class="card-body">
                        <!-- Datos Principales -->
                        @if(isset($results['DatosPrincipales']['list']['multiRef']))
                            <h4 class="text-info">Datos Principales</h4>
                            <ul>
                                <li><strong>Código de Ubigeo:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['ddp_ubigeo']['$'] }}</li>
                                <li><strong>Código de Departamento:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['cod_dep']['$'] }}</li>
                                <li><strong>Descripción del Departamento:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['desc_dep']['$'] }}</li>
                                <li><strong>Código de Provincia:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['cod_prov']['$'] }}</li>
                                <li><strong>Descripción de la Provincia:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['desc_prov']['$'] }}</li>
                                <li><strong>Nombre o Razón Social:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['ddp_nombre']['$'] }}</li>
                                <li><strong>Estado:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['desc_estado']['$'] }}</li>
                            </ul>
                        @endif

                        <!-- Datos Secundarios -->
                        @if(isset($results['DatosSecundarios']['list']['multiRef']))
                            <h4 class="text-info">Datos Secundarios</h4>
                            <ul>
                                <li><strong>Fecha de Inicio:</strong> {{ $results['DatosSecundarios']['list']['multiRef']['dds_inicio']['$'] }}</li>
                                <li><strong>Fecha de Nacimiento:</strong> {{ $results['DatosSecundarios']['list']['multiRef']['dds_fecnac']['$'] }}</li>
                                <li><strong>Sexo:</strong> {{ $results['DatosSecundarios']['list']['multiRef']['desc_sexo']['$'] }}</li>
                                <li><strong>Nacionalidad:</strong> {{ $results['DatosSecundarios']['list']['multiRef']['desc_nacion']['$'] }}</li>
                            </ul>
                        @endif

                        <!-- Domicilio Legal -->
                        @if(isset($results['DomicilioLegal']['list']['getDomicilioLegalResponse']))
                            <h4 class="text-info">Domicilio Legal</h4>
                            <p>{{ $results['DomicilioLegal']['list']['getDomicilioLegalResponse']['getDomicilioLegalReturn']['$'] }}</p>
                        @endif

                        <!-- Establecimientos Anexos -->
                        @if(isset($results['EstablecimientosAnexos']['list']['getEstablecimientosAnexosResponse']['getEstablecimientosAnexosReturn']['@arrayType']))
                            <h4 class="text-info">Establecimientos Anexos</h4>
                            <p>No hay establecimientos anexos registrados.</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>

</div>

@endsection
