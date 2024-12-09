@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">  
          <div class="col-sm-6">
            <h1>Editar Notas del Estudiante</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <!-- form start -->
                <form method="post" action="">
                  {{ csrf_field() }}
                  <div class="card-body">
                    <div class="form-group">
                      <label>Nombre del Estudiante</label>
                      <input type="text" class="form-control" value="{{ $getRecord->estudiante_name }}" readonly>
                    </div>
                    
                    <div class="form-group">
                      <label>Apellido del Estudiante</label>
                      <input type="text" class="form-control" value="{{ $getRecord->estudiante_last_name }}" disabled>
                    </div>

                    <div class="form-group">
                      <label>Curso</label>
                      <input type="text" class="form-control" value="{{ $getRecord->curso_name }}" disabled>
                    </div>

                    <div class="form-group">
                      <label>Periodo</label>
                      <input type="text" class="form-control" value="{{ $getRecord->periodo_name }}" disabled>
                    </div>

                    <div class="form-group">
                      <label>1 Promedio Parcial</label>
                      <input type="number" class="form-control" name="nota1" value="{{ $getRecord->nota1 }}" min="0" max="20" step="0.01" placeholder="Nota 1">
                    </div>

                    <div class="form-group">
                      <label>2 Promedio Parcial</label>
                      <input type="number" class="form-control" name="nota2" value="{{ $getRecord->nota2 }}" min="0" max="20" step="0.01" placeholder="Nota 2">
                    </div>

                  

                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Actualizar Notas</button>
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