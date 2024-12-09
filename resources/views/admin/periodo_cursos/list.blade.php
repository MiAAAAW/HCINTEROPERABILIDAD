@extends('layouts.app')

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Asignar Cursos a Plan de Estudio</h1>
        </div>
        <div class="col-sm-6" style="text-align: right;">
          <a href="{{url('admin/periodo_cursos/add')}}" class="btn btn-primary">Asignar Cursos a Plan de Estudio</a>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Buscar</h3>
            </div>
            <form method="post" action="">
              {{ csrf_field () }}
              <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-2">
                    <label>Plan de Estudio</label>
                    <input type="text" class="form-control" value="{{ Request::get('periodo_name')}}" name="periodo_name" placeholder="Plan">
                  </div>
                  <div class="form-group col-md-2">
                    <label>Cursos</label>
                    <input type="text" class="form-control" value="{{ Request::get('cursos_name')}}" name="cursos_name" placeholder="Cursos">
                  </div>
                  <div class="form-group col-md-2">
                    <label>Código</label>
                    <input type="text" class="form-control" value="{{ Request::get('cod')}}" name="cod" placeholder="Código">
                  </div>
                  <div class="form-group col-md-2">
                    <label>Mención</label>
                    <input type="text" class="form-control" value="{{ Request::get('mension')}}" name="mension" placeholder="Mención">
                  </div>
                  <div class="form-group col-md-2">
                    <label>Fecha</label>
                    <input type="date" class="form-control" name="date" value="{{ Request::get('date')}}" placeholder="Fecha">
                  </div>
                  <div class="form-group col-md-2">
                    <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Buscar</button>
                    <a href="{{url('admin/periodo_cursos/list')}}" class="btn btn-success" style="margin-top: 30px;">Limpiar</a>
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
              <h1 class="card-title">Cursos Asignados</h1>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Plan</th>
                    <th>Curso</th>
                    <th>Cod</th>
                    <th>Mención</th>
                    <th>Status</th>
                    <th>Fecha Creada</th>
                    <th>Accion</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($getRecord as $value)
                    <tr>
                      <td>{{ $value->id }}</td>
                      <td>{{ $value->periodo_name }}</td>
                      <td>{{ $value->cursos_name }}</td>
                      <td>{{ $value->cod }}</td>
                      <td>{{ $value->mension }}</td>
                      <td>
                        @if($value->status == 0)
                          Active
                        @else
                          Inactive
                        @endif
                      </td>
                      <td>{{ date('d-m-Y H:i A' , strtotime($value->created_at ))}}</td>
                      <td>
                        <!-- <a href="{{url('admin/periodo_cursos/edit/' .$value->id)}}" class="btn btn-primary">Editar</a>--->
                        <div style="display: flex; gap: 5px;">
                          <a href="{{url('admin/periodo_cursos/edit_single/' .$value->id)}}" class="btn btn-primary">Editar</a>
                          <a href="{{url('admin/periodo_cursos/delete/' .$value->id)}}" class="btn btn-danger">Borrar</a>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <div style="padding: 10px; float: right;">
                {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
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