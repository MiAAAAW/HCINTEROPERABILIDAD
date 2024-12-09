@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">  
          <div class="col-sm-6">
            <h1>Editar</h1>
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
                            <label>Plan de Estudio</label>
                            <select class="form-control" name="periodo_id" required >
                                <option value="">Seleccionar Plan de Estudio</option>
                                @foreach ($getPeriodo as $periodo )
                                <option {{ ($getRecord->periodo_id == $periodo->id) ? 'selected' : '' }} value="{{ $periodo->id}}">{{ $periodo->name}}</option>  
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group">
                            <label>Cursos</label>
                            <select class="form-control" name="cursos_id" required >
                                <option value="">Seleccionar Curso</option>
                                @foreach ($getCursos as $cursos )
                                <option {{ ($getRecord->cursos_id == $cursos->id) ? 'selected' : '' }} value="{{ $cursos->id}}">{{ $cursos->name}}</option>  
                                @endforeach
                            </select>

                        </div>
                    
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status" >
                                <option {{ ($getRecord->status == 0) ? 'selected' : '' }} value="0">Activo</option>
                                <option {{ ($getRecord->status == 1) ? 'selected' : '' }} value="1">Inactivo</option>
                            </select>

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