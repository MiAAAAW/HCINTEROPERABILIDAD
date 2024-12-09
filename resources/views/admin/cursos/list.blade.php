@extends('layouts.app')

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Cursos</h1>
        </div>
        <div class="col-sm-6" style="text-align: right;">
          <a href="{{url('admin/cursos/add')}}" class="btn btn-primary">Agregar Nuevo Curso</a>
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
              <h3 class="card-title">Buscar Cursos</h3>
            </div>
            <form method="post" action="">
              {{ csrf_field () }}
              <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-2">
                    <label>Nombre</label>
                    <input type="text" class="form-control" value="{{ Request::get('name')}}" name="name" placeholder="Nombre">
                  </div>
                  <div class="form-group col-md-1">
                    <label>Código</label>
                    <input type="text" class="form-control" value="{{ Request::get('cod')}}" name="cod" placeholder="Código">
                  </div>
                  <div class="form-group col-md-2">
                    <label>Mención</label>
                    <input type="text" class="form-control" value="{{ Request::get('mension')}}" name="mension" placeholder="Mención">
                  </div>
                  <div class="form-group col-md-2">
                    <label>Modalidad</label>
                    <select class="form-control" name="type">
                      <option value="">Modalidad</option>
                      <option {{(Request::get('type') == 'Regular') ? 'selected' : ''}} value="Regular">Regular</option>
                      <option {{(Request::get('type') == 'Nivelacion') ? 'selected' : '' }} value="Nivelacion">Nivelacion</option>
                      <option {{(Request::get('type') == 'Extraordinario') ? 'selected' : '' }} value="Extraordinario">Electivo</option>
                    </select>
                  </div>
                  <div class="form-group col-md-2">
                    <label>Fecha</label>
                    <input type="date" class="form-control" name="date" value="{{ Request::get('date')}}" placeholder="Fecha">
                  </div>
                  <div class="form-group col-md-3" style="display: flex; gap: 5px;">
                    
                    <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Buscar</button>
                    <a href="{{url('admin/cursos/list')}}" class="btn btn-success" style="margin-top: 30px;">Limpiar</a>
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
              <h3 class="card-title">Lista de Cursos </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Curso</th>
                    <th>Cód</th>
                    <th>Mención</th>
                    <th>Modalidad</th>
                    <th>Status</th>
                    <th>Fecha Creada</th>
                    <th>Acción</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($getRecord as $value)
                    <tr>
                      <td>{{ $value->id }}</td>
                      <td>{{ $value->name }}</td>
                      <td>{{ $value->cod }}</td>
                      <td>{{ $value->mension }}</td>
                      <td>{{ $value->type }}</td>
                      <td>
                        @if($value->status == 0)
                          Active
                        @else
                          Inactive
                        @endif
                      </td>
                      <td>{{ date('d-m-Y H:i A' , strtotime($value->created_at ))}}</td>
                      <td>
                        <div style="display: flex; gap: 5px;">
                          <a href="{{url('admin/cursos/edit/' .$value->id)}}" class="btn btn-primary">Editar</a>
                          <a href="{{url('admin/cursos/delete/' .$value->id)}}" class="btn btn-danger">Borrar</a>
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