@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Asignar Plan de Estudio-Cursos</h1>
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
                        <form method="post" action="{{ url('admin/periodo_cursos/add') }}">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Plan de Estudio</label>
                                    <select class="form-control select2" name="periodo_id" required>
                                        <option value="">Seleccionar Plan de Estudios</option>
                                        @foreach ($getPeriodo as $periodo)
                                        <option value="{{ $periodo->id }}">{{ $periodo->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Cursos</label>
                                    @php
                                    $menciones = [];
                                    foreach ($getCursos as $curso) {
                                        $menciones[$curso->mension][] = $curso;
                                    }

                                    $totalCursos = count($getCursos);
                                    $half = ceil($totalCursos / 2);
                                    $col1 = [];
                                    $col2 = [];
                                    $counter = 0;

                                    foreach ($menciones as $mension => $cursos) {
                                        foreach ($cursos as $curso) {
                                            if ($counter < $half) {
                                                $col1[$mension][] = $curso;
                                            } else {
                                                $col2[$mension][] = $curso;
                                            }
                                            $counter++;
                                        }
                                    }
                                    @endphp

                                    <div class="row">
                                        <div class="col-md-6">
                                            @foreach ($col1 as $mension => $cursos)
                                            <h5>MENCION: {{ $mension }}</h5>
                                            @foreach ($cursos as $curso)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="cursos_id[]" value="{{ $curso->id }}" id="curso{{ $curso->id }}">
                                                <label class="form-check-label" for="curso{{ $curso->id }}">
                                                    {{ $curso->cod }} - {{ $curso->name }}
                                                </label>
                                            </div>
                                            @endforeach
                                            @endforeach
                                        </div>
                                        <div class="col-md-6">
                                            @foreach ($col2 as $mension => $cursos)
                                            <h5>MENCION: {{ $mension }}</h5>
                                            @foreach ($cursos as $curso)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="cursos_id[]" value="{{ $curso->id }}" id="curso{{ $curso->id }}">
                                                <label class="form-check-label" for="curso{{ $curso->id }}">
                                                    {{ $curso->cod }} - {{ $curso->name }}
                                                </label>
                                            </div>
                                            @endforeach
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status" required>
                                        <option value="0">Activo</option>
                                        <option value="1">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Asignar</button>
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

<!-- Iniciar Select2 -->
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

@endsection