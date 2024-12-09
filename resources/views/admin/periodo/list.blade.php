@extends('layouts.app')

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Plan de Estudio</h1>
        </div>
        <div class="col-sm-6" style="text-align: right;">
          <a href="{{url('admin/periodo/add')}}" class="btn btn-primary">Agregar Nuevo Plan de Estudios</a>
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
                       <h3 class="card-title">Buscar Plan de Estudio</h3>
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
                          <label>Fecha</label>
                          <input type="date" class="form-control" name="date" value="{{ Request::get('date')}}"  placeholder="Fecha">
                        
                        </div>

                        <div class="form-group col-md-3">
                          <button class="btn btn-primary" type="submit" style="margin-top: 30px;">Buscar</button>
                          <a href="{{url('admin/periodo/list')}}" class="btn btn-success" style="margin-top: 30px;">Limpiar</a>
                        </div>
                      </div>
                    </div>
                  </form>
               </div>
                <!-- /.card -->

            @include('_message')
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h1 class="card-title">Lista </h1>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nombre</th>
                      <th>Status</th>
                      <th>Creado Por</th>
                      <th>Fecha Creada</th>
                      <th>Accion</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($getRecord as $value)
                      <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->name }}</td>
                        <td>  
                           @if($value->status == 0)
                             Active 
                           @else
                             Inactive
                           @endif
                        </td>
                        <td>{{ $value->created_by_name }}</td>
                        <td>{{ date('d-m-Y H:i A' , strtotime($value->created_at ))}}</td>
                        <td>
                          <div style="display: flex; gap: 5px;">
                            <a href="{{url('admin/periodo/edit/' .$value->id)}}" class="btn btn-primary">Editar</a>
                            <a href="{{url('admin/periodo/delete/' .$value->id)}}" class="btn btn-danger">Borrar</a> 
                          </div> 
                        <td>  
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