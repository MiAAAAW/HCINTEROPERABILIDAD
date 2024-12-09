@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">  
          <div class="col-sm-6">
            <h1>Agregar Nuevo Curso</h1>
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
                <form method="post" action="" onsubmit="return validateForm()">
                  {{ csrf_field () }}
                    <div class="card-body">
                        <div class="form-group">
                            <label>Código del Curso</label>
                            <input type="text" class="form-control" name="cod" id="cod" required placeholder="Ejemplo: C001">
                        </div>

                        <div class="form-group">
                            <label>Curso</label>
                            <input type="text" class="form-control" name="name" required placeholder="Ejemplo: NEONATOLOGIA">
                        </div>
                        
                        <div class="form-group">
                            <label>Mención</label>
                            <input type="text" class="form-control" name="mension" required placeholder="Ejemplo: Pediatría">
                        </div>

                        <div class="form-group">
                            <label>Modalidad</label>
                            <select class="form-control" name="type" required>
                                <option value="">Seleccionar Modalidad</option>
                                <option value="Regular">Regular</option>
                                <option value="Nivelacion">Nivelacion</option>
                                <option value="Extraordinario">Electivo</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
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
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script>
    function validateForm() {
        var cod = document.getElementById('cod').value;
        if (isNaN(cod)) {
            alert("El código del curso debe ser solo números.");
            return false;
        }
        return true;
    }
</script>

@endsection