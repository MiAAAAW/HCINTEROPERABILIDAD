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
                                <option value="">Seleccionar Periodo</option>
                                @foreach ($getPeriodo as $periodo )
                                <option {{ ($getRecord->periodo_id == $periodo->id) ? 'selected' : '' }} value="{{ $periodo->id}}">{{ $periodo->name}}</option>  
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group">
                            <label>Cursos</label>
                                @foreach ($getCursos as $cursos )
                                   @php
                                       $checked = "";
                                   @endphp
                                   @foreach ($getPrdCursosID as $PrdCursos)
                                      @if ($PrdCursos->cursos_id == $cursos->id)
                                          @php
                                             $checked = "checked";  
                                          @endphp
                                      @endif     
                                   @endforeach

                                <div>
                                   <label style="font-weight: normal;">
                                    <input {{ $checked }}  type="checkbox" value="{{ $cursos->id}}" name="cursos_id[]">{{$cursos->name}}
                                   </label>
                                </div>
                                @endforeach

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