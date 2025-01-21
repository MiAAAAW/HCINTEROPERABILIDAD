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
                                <li><strong>Descripción de Departamento:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['desc_dep']['$'] }}</li>
                                <li><strong>Código de Provincia:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['cod_prov']['$'] }}</li>
                                <li><strong>Descripción de Provincia:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['desc_prov']['$'] }}</li>
                                <li><strong>Código de Distrito:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['cod_dist']['$'] }}</li>
                                <li><strong>Descripción de Distrito:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['desc_dist']['$'] }}</li>
                                <li><strong>Código de Actividad Económica:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['ddp_ciiu']['$'] }}</li>
                                <li><strong>Descripción de Actividad Económica:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['desc_ciiu']['$'] }}</li>
                                <li><strong>Estado del Contribuyente:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['ddp_estado']['$'] }}</li>
                                <li><strong>Descripción del Estado:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['desc_estado']['$'] }}</li>
                                <li><strong>Fecha de Actualización:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['ddp_fecact']['$'] }}</li>
                                <li><strong>Fecha de Alta:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['ddp_fecalt']['$'] }}</li>
                                <li><strong>Fecha de Baja:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['ddp_fecbaj']['$'] }}</li>
                                <li><strong>Tipo de Persona:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['ddp_identi']['$'] }}</li>
                                <li><strong>Descripción de Tipo de Persona:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['desc_identi']['$'] }}</li>
                                <li><strong>Libreta Tributaria:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['ddp_lllttt']['$'] }}</li>
                                <li><strong>Nombre o Razón Social:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['ddp_nombre']['$'] }}</li>
                                <li><strong>Nombre de la Vía:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['ddp_nomvia']['$'] }}</li>
                                <li><strong>Número:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['ddp_numer1']['$'] }}</li>
                                <li><strong>Interior:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['ddp_inter1']['$'] }}</li>
                                <li><strong>Nombre de la Zona:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['ddp_nomzon']['$'] }}</li>
                                <li><strong>Referencia de Ubicación:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['ddp_refer1']['$'] }}</li>
                                <li><strong>Condición del Domicilio:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['ddp_flag22']['$'] }}</li>
                                <li><strong>Descripción de Condición del Domicilio:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['desc_flag22']['$'] }}</li>
                                <li><strong>Código de Dependencia:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['ddp_numreg']['$'] }}</li>
                                <li><strong>Descripción de Dependencia:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['desc_numreg']['$'] }}</li>
                                <li><strong>Número de RUC:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['ddp_numruc']['$'] }}</li>
                                <li><strong>Código de Tipo de Vía:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['ddp_tipvia']['$'] }}</li>
                                <li><strong>Descripción de Tipo de Vía:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['desc_tipvia']['$'] }}</li>
                                <li><strong>Código de Tipo de Zona:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['ddp_tipzon']['$'] }}</li>
                                <li><strong>Descripción de Tipo de Zona:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['desc_tipzon']['$'] }}</li>
                                <li><strong>Tipo de Contribuyente:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['ddp_tpoemp']['$'] }}</li>
                                <li><strong>Descripción del Contribuyente:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['desc_tpoemp']['$'] }}</li>
                                <li><strong>Código de Secuencia:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['ddp_secuen']['$'] }}</li>
                                <li><strong>Estado Activo:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['esActivo']['$'] ? 'Sí' : 'No' }}</li>
                                <li><strong>Estado Habido:</strong> {{ $results['DatosPrincipales']['list']['multiRef']['esHabido']['$'] ? 'Sí' : 'No' }}</li>
                            </ul>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>

</div>

@endsection
