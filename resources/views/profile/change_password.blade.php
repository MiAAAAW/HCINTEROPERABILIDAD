@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">  
          <div class="col-sm-6">
            <h1>Cambiar Contraseña</h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            @include('_message')
          <!-- left column -->
          <div class="col-md-12 ">
            <!-- general form elements -->
            <div class="card card-primary">
              <!-- form start -->
                <form method="post" action="">
                  {{ csrf_field() }}
                    <div class="card-body">
                        <div class="form-group">
                            <label>Contraseña Actual</label>
                            <input type="password" class="form-control" name="old_password" required placeholder="Contraseña Actual">
                        </div>
                        <div class="form-group">
                            <label>Contraseña Nueva </label>
                            <input type="password" class="form-control" name="new_password" required placeholder="Contraseña Nueva">
                        </div>
                    
                    
                    </div>
                <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Actualizar</button>
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