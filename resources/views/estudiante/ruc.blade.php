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
                    <!-- Renderizar tablas de resultados -->
                    {!! renderTable($result) !!}
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

@php
/**
 * Función para renderizar tablas recursivamente.
 *
 * @param array $data Datos a procesar.
 * @return string HTML generado.
 */
function renderTable($data)
{
    $html = '<table class="table table-bordered">';
    foreach ($data as $key => $value) {
        $html .= '<tr>';
        $html .= '<th>' . ucfirst(str_replace('_', ' ', $key)) . '</th>';
        if (is_array($value)) {
            $html .= '<td>' . renderTable($value) . '</td>'; // Llamada recursiva para subarreglos.
        } else {
            $html .= '<td>' . htmlspecialchars($value) . '</td>';
        }
        $html .= '</tr>';
    }
    $html .= '</table>';
    return $html;
}
@endphp
