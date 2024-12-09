@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Editar Usuario</h1>
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
                        <form method="post" action="{{ url('admin/estudiante/edit/' . $estudiante->id) }}">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nombres</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $estudiante->name) }}" placeholder="Nombres">
                                </div>
                                <div class="form-group">
                                    <label>Apellidos</label>
                                    <input type="text" class="form-control" name="last_name" value="{{ old('last_name', $estudiante->last_name) }}" placeholder="Apellidos">
                                </div>
                                <div class="form-group">
                                    <label>DNI</label>
                                    <input type="text" class="form-control" name="dni" value="{{ old('dni', $estudiante->dni) }}" placeholder="Documento Nacional De Identidad">
                                    <div style="color:red">{{ $errors->first('dni') }}</div>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="email" value="{{ old('email', $estudiante->email) }}" placeholder="Email">
                                    <div style="color:red">{{ $errors->first('email') }}</div>
                                </div>
                                <div class="form-group">
                                    <label>Código del Usuario<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name="codigo" value="{{ old('codigo', $estudiante->codigo) }}" required placeholder="Código del Estudiante">
                                    <div style="color:red">{{ $errors->first('codigo') }}</div>
                                </div>
                                <div class="form-group">
                                    <label>Contraseña (dejar en blanco para no cambiar)</label>
                                    <input type="password" class="form-control" name="password" placeholder="Contraseña">
                                    <p>Ingresa la nueva contraseña</p>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection
