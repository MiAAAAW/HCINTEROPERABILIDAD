@extends('layouts.app')

@section('content')
<div class="content-wrapper">

  <!-- Content Header -->
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Consulta de RUC - Servicios SUNAT</h1>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <section class="content">
    <div class="container">

      <!-- Notificaciones de Laravel -->
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

      <!-- Formularios -->
      <div class="row" style="gap: 20px; align-items: stretch;">

        <!-- Consulta de RUC -->
        <div class="col-md-6">
          <div class="card">
            <!-- Header -->
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center"
                 onclick="toggleCollapse('collapseConsultarRUC', 'iconConsultarRUC')"
                 style="cursor: pointer;">
              <h3 class="card-title mb-0">Consulta de RUC</h3>
              <i id="iconConsultarRUC" class="fas fa-chevron-down toggle-icon ml-auto"></i>
            </div>

            <!-- Contenido colapsable -->
            <div id="collapseConsultarRUC" class="collapse show">
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
        </div>

        <!-- Resultados -->
        @if (isset($results))
        <div class="col-md-12">
          <div class="card">
            <div class="card-header bg-info text-white">
              <h3 class="card-title mb-0">Resultados para el RUC: {{ $ruc }}</h3>
            </div>
            <div class="card-body">
              <!-- Resultados detallados -->
              @foreach ($results as $service => $result)
                <div class="card mt-3">
                  <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">{{ $service }}</h5>
                  </div>
                  <div class="card-body">
                    @if (isset($result['error']) && $result['error'])
                      <p class="text-danger">Error: {{ $result['message'] }}</p>
                    @else
                      <table class="table table-bordered">
                        <tbody>
                          @foreach ($result as $key => $value)
                            <tr>
                              <th>{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                              <td>
                                @if (is_array($value))
                                  <ul>
                                    @foreach ($value as $subKey => $subValue)
                                      <li>
                                        <strong>{{ ucfirst(str_replace('_', ' ', $subKey)) }}:</strong>
                                        {{ is_array($subValue) ? json_encode($subValue, JSON_PRETTY_PRINT) : $subValue }}
                                      </li>
                                    @endforeach
                                  </ul>
                                @else
                                  {{ $value }}
                                @endif
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    @endif
                  </div>
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
