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
                                @php $data = $results['DatosPrincipales']['list']['multiRef']; @endphp
                                <li><strong>Nombre o Razón Social:</strong> {{ $data['ddp_nombre']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Descripción del Estado:</strong> {{ $data['desc_estado']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Descripción del Contribuyente:</strong> {{ $data['desc_tpoemp']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Descripción de Tipo de Persona:</strong> {{ $data['desc_identi']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Descripción de Actividad Económica:</strong> {{ $data['desc_ciiu']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Código de Ubigeo:</strong> {{ $data['ddp_ubigeo']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Código de Departamento:</strong> {{ $data['cod_dep']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Descripción de Departamento:</strong> {{ $data['desc_dep']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Código de Provincia:</strong> {{ $data['cod_prov']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Descripción de Provincia:</strong> {{ $data['desc_prov']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Código de Distrito:</strong> {{ $data['cod_dist']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Descripción de Distrito:</strong> {{ $data['desc_dist']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Código de Actividad Económica:</strong> {{ $data['ddp_ciiu']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Estado del Contribuyente:</strong> {{ $data['ddp_estado']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Fecha de Actualización:</strong> {{ $data['ddp_fecact']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Fecha de Alta:</strong> {{ $data['ddp_fecalt']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Fecha de Baja:</strong> {{ $data['ddp_fecbaj']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Tipo de Persona:</strong> {{ $data['ddp_identi']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Libreta Tributaria:</strong> {{ $data['ddp_lllttt']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Nombre de la Vía:</strong> {{ $data['ddp_nomvia']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Número:</strong> {{ $data['ddp_numer1']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Interior:</strong> {{ $data['ddp_inter1']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Nombre de la Zona:</strong> {{ $data['ddp_nomzon']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Referencia de Ubicación:</strong> {{ $data['ddp_refer1']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Condición del Domicilio:</strong> {{ $data['ddp_flag22']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Descripción de Condición del Domicilio:</strong> {{ $data['desc_flag22']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Código de Dependencia:</strong> {{ $data['ddp_numreg']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Descripción de Dependencia:</strong> {{ $data['desc_numreg']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Número de RUC:</strong> {{ $data['ddp_numruc']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Código de Tipo de Vía:</strong> {{ $data['ddp_tipvia']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Descripción de Tipo de Vía:</strong> {{ $data['desc_tipvia']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Código de Tipo de Zona:</strong> {{ $data['ddp_tipzon']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Descripción de Tipo de Zona:</strong> {{ $data['desc_tipzon']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Tipo de Contribuyente:</strong> {{ $data['ddp_tpoemp']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Código de Secuencia:</strong> {{ $data['ddp_secuen']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Estado Activo:</strong> {{ $data['esActivo']['$'] ?? 'No disponible' }}</li>
                                <li><strong>Estado Habido:</strong> {{ $data['esHabido']['$'] ?? 'No disponible' }}</li>
                            </ul>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>

</div>

@endsection
