@extends('layouts.app')

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Lista de Admins (Total : {{ $getRecord -> total() }})</h1>
        </div>
        <div class="col-sm-6" style="text-align: right;">
          <a href="{{url('admin/admin/add')}}" class="btn btn-primary">Agregar Nuevo Admin</a>
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
                       <h3 class="card-title">Buscar Admin</h3>
                  </div>
                  <form method="post" action="">
                     {{ csrf_field () }}
                    <div class="card-body">
                      <div class="row">

                      <div class="form-group col-md-3">
                        <label>Nombre</label>
                        <input type="text" class="form-control"  value="{{ Request::get('name')}}" name="name"  placeholder="Nombre">
                      </div>

                      <div class="form-group col-md-3">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" value="{{ Request::get('email')}}"  placeholder="Email">

                      </div>

                      <div class="form-group col-md-3">
                        <label>Fecha</label>
                        <input type="date" class="form-control" name="date" value="{{ Request::get('date')}}"  placeholder="Fecha">

                      </div>

                      <div class="form-group col-md-3">
                        <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Buscar</button>
                        <a href="{{url('admin/admin/list')}}" class="btn btn-success" style="margin-top: 30px;">Limpiar</a>
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
                <h1 class="card-title">Lista de Admins </h1>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nombre</th>
                      <th>Email</th>
                      <th>Fecha Creada</th>
                      <th>Accion</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($getRecord as $value)
                        <tr>
                          <td>{{ $value ->id }}</td>
                          <td>{{ $value ->name }}</td>
                          <td>{{ $value ->email }}</td>
                          <td>{{ date('d-m-Y H:i A', strtotime($value->created_at)) }}</td>
                          <td>
                            <a href="{{url('admin/admin/edit/' .$value->id)}}" class="btn btn-primary">Editar</a>
                            <a href="{{url('admin/admin/delete/' .$value->id)}}" class="btn btn-danger">Borrar</a>
                          <td>
                        <tr>
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

        <!-- /.row -->
      </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

@endsection
