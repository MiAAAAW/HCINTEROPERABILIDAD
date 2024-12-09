@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Agregar Nuevo Usuario</h1>
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
                                <!-- Mostrar alertas de error generales -->
                                @include('_message')

                                <div class="form-group">
                                    <label>Nombres</label>
                                    <input type="text" class="form-control" value="{{ old('name') }}" name="name" required placeholder="Nombres">
                                    @if ($errors->has('name'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>Apellidos</label>
                                    <input type="text" class="form-control" value="{{ old('last_name') }}" name="last_name" required placeholder="Apellidos">
                                    @if ($errors->has('last_name'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ $errors->first('last_name') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>DNI</label>
                                    <input type="text" class="form-control" value="{{ old('dni') }}" name="dni" placeholder="Documento Nacional De Identidad">
                                    @if ($errors->has('dni'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ $errors->first('dni') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" value="{{ old('email') }}" name="email" placeholder="Email">
                                    @if ($errors->has('email'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>Código del Usuario</label>
                                    <input type="text" class="form-control" value="{{ old('codigo') }}" name="codigo" required placeholder="Código del Usuario">
                                    @if ($errors->has('codigo'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ $errors->first('codigo') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <input type="password" class="form-control" name="password" required placeholder="Contraseña">
                                    @if ($errors->has('password'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ $errors->first('password') }}
                                        </div>
                                    @endif
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
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection
