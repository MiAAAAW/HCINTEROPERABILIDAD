@extends('layouts.app')

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Calificaciones (Total: {{ $getRecord->total() }})</h1>
          <p>
            En Proceso: {{ $total_en_proceso }},
            Aprobados: {{ $total_aprobados }},
            Desaprobados: {{ $total_desaprobados }}
          </p>
        </div>
        <div class="col-sm-6" style="text-align: right;">
          <a href="{{ url('admin/inscribir/add') }}" class="btn btn-primary">Inscribir Estudiante a Curso</a>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Buscar Inscripción</h3>
            </div>
            <form method="get" action="{{ url('admin/inscribir/list') }}">
              <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-2">
                    <label>Nombres</label>
                    <input type="text" class="form-control" value="{{ Request::get('estudiante_name') }}" name="estudiante_name" placeholder="Nombre del Estudiante">
                  </div>
                  <div class="form-group col-md-2">
                    <label>Apellidos</label>
                    <input type="text" class="form-control" value="{{ Request::get('estudiante_last_name') }}" name="estudiante_last_name" placeholder="Apellido del Estudiante">
                  </div>
                  <div class="form-group col-md-2">
                    <label>Código de Estudiante</label>
                    <input type="text" class="form-control" value="{{ Request::get('codigo') }}" name="codigo" placeholder="Código de Estudiante">
                  </div>
                  <div class="form-group col-md-1">
                    <label>Plan</label>
                    <input type="text" class="form-control" value="{{ Request::get('periodo_name') }}" name="periodo_name" placeholder="Plan">
                  </div>
                  <div class="form-group col-md-1">
                    <label>Cod</label>
                    <input type="text" class="form-control" value="{{ Request::get('cod') }}" name="cod" placeholder="Código">
                  </div>
                  <div class="form-group col-md-2">
                    <label>Nombre del Curso</label>
                    <input type="text" class="form-control" value="{{ Request::get('curso_name') }}" name="curso_name" placeholder="Nombre del Curso">
                  </div>
                  
                  <div class="form-group col-md-2">
                    <label>Mención</label>
                    <input type="text" class="form-control" value="{{ Request::get('mension') }}" name="mension" placeholder="Mención">
                  </div> 
                  <div class="form-group col-md-2">
                    <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Buscar</button>
                    <a href="{{ url('admin/inscribir/list') }}" class="btn btn-success" style="margin-top: 30px;">Limpiar</a>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </form>
          </div>
          <!-- /.card -->

          @include('_message')
          <!-- /.card -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Lista de Inscripciones</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>CodigoEst</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Cod</th>
                    <th>Curso</th>
                    <th>PlanEst</th>
                    <th>Mención</th>
                    <th>1PP</th>
                    <th>2PP</th>
                    <th>PF</th>
                    <th>Estado</th>
                    <th>Acción</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($getRecord as $value)
                    <tr>
                      <td>{{ $value->codigo }}</td>
                      <td>{{ $value->estudiante_name }}</td>
                      <td>{{ $value->estudiante_last_name }}</td>
                      <td>{{ $value->cod }}</td>
                      <td>{{ $value->curso_name }}</td>
                      <td>{{ $value->periodo_name }}</td>
                      <td>{{ $value->mension }}</td>
                      <td>{{ $value->nota1 }}</td>
                      <td>{{ $value->nota2 }}</td>
                      <td>{{ $value->promedio }}</td>
                      <td>
                        @if($value->aprobado == 'Aprobado')
                          <span class="badge badge-success" style="background-color: green;">Aprobado</span>
                        @elseif($value->aprobado == 'Desaprobado')
                          <span class="badge badge-danger" style="background-color: rgb(216, 129, 7);">Desaprobado</span>
                        @else
                          <span class="badge badge-warning" style="background-color: rgb(82, 196, 241);">En proceso</span>
                        @endif
                      </td>
                      <td>
                        <div style="display: flex; gap: 5px;">
                          <a href="{{ url('admin/inscribir/edit/' . $value->id . '?' . http_build_query(Request::all())) }}" class="btn btn-primary">Editar</a>
                          <a href="{{ url('admin/inscribir/delete/' . $value->id . '?' . http_build_query(Request::all())) }}" class="btn btn-danger">Borrar</a>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <div style="padding: 10px; float: right;">
                {!! $getRecord->appends(Request::all())->links() !!}
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

@endsection