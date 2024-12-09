@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">  
          <div class="col-sm-6">
            <h1>Agregar Nuevo Periodo Academico</h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12 ">
            <!-- general form elements -->
            <div class="card card-primary">
              <!-- form start -->
                <form method="post" action="">
                  {{ csrf_field () }}
                    <div class="card-body">
                        <div class="form-group">
                            <label>Periodo Academico</label>
                            <input type="text" class="form-control" name="name" required placeholder="Ejemplo :  2024-I ,2024 ">
                        </div>
                    
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" >
                                <option value="0">Activo</option>
                                <option value="1">Inactivo</option>
                            </select>

                        </div>
                    
                    
                    </div>
                <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Agregar</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
          <!-- right column -->
     
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection