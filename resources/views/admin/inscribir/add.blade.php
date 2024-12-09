@extends('layouts.app')

@section('content')

<!-- Incluir Bootstrap CSS y JS para el modal -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Inscribir Estudiante a Curso</h1>
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
                        <form method="post" action="{{ url('admin/inscribir/add') }}">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>Nombres</label>
                                        <input type="text" class="form-control" id="student-search-name" placeholder="Nombres">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Apellidos</label>
                                        <input type="text" class="form-control" id="student-search-last-name" placeholder="Apellidos">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>DNI</label>
                                        <input type="text" class="form-control" id="student-search-dni" placeholder="DNI ">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Código</label>
                                        <input type="text" class="form-control" id="student-search-code" placeholder="Código ">
                                    </div>
                                    <div class="form-group col-md-2" style="margin-top: 30px;">
                                        <button type="button" class="btn btn-primary" id="search-student-button">Buscar</button>
                                        <button type="button" class="btn btn-success ml-2" id="clear-search-button">Limpiar</button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Estudiante: Apellidos y Nombres/Dni/Codigo</label>
                                    <select class="form-control" id="student-select" name="user_id" required>
                                        <option value="">Seleccionar Estudiante</option>
                                        @foreach ($getEstudiantes as $estudiante)
                                            <option value="{{ $estudiante->id }}" data-name="{{ $estudiante->name }}" data-last-name="{{ $estudiante->last_name }}" data-dni="{{ $estudiante->dni }}" data-code="{{ $estudiante->codigo }}">
                                                {{ $estudiante->last_name }} {{ $estudiante->name }}   {{ $estudiante->dni }}   {{ $estudiante->codigo }} 
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Seleccionar Cursos: Curso/Codigo/Plan de Estudio</label>
                                    @php
                                        $menciones = [];
                                        foreach ($getPeriodoCursos as $periodoCurso) {
                                            $menciones[$periodoCurso->curso->mension][] = $periodoCurso;
                                        }
                                        $totalCursos = count($getPeriodoCursos);
                                        $half = ceil($totalCursos / 2);
                                        $col1 = [];
                                        $col2 = [];
                                        $counter = 0;
                                        foreach ($menciones as $mension => $cursos) {
                                            foreach ($cursos as $periodoCurso) {
                                                if ($counter < $half) {
                                                    $col1[$mension][] = $periodoCurso;
                                                } else {
                                                    $col2[$mension][] = $periodoCurso;
                                                }
                                                $counter++;
                                            }
                                        }
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-6">
                                            @foreach ($col1 as $mension => $cursos)
                                                <h5>{{ $mension }}</h5>
                                                @foreach ($cursos as $periodoCurso)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="periodo_cursos_ids[]" value="{{ $periodoCurso->id }}" id="curso-{{ $periodoCurso->id }}">
                                                        <label class="form-check-label" for="curso-{{ $periodoCurso->id }}">
                                                            {{ $periodoCurso->curso->name }} / {{ $periodoCurso->curso->cod }} / {{ $periodoCurso->periodo->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        </div>
                                        <div class="col-md-6">
                                            @foreach ($col2 as $mension => $cursos)
                                                <h5>{{ $mension }}</h5>
                                                @foreach ($cursos as $periodoCurso)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="periodo_cursos_ids[]" value="{{ $periodoCurso->id }}" id="curso-{{ $periodoCurso->id }}">
                                                        <label class="form-check-label" for="curso-{{ $periodoCurso->id }}">
                                                            {{ $periodoCurso->curso->name }} / {{ $periodoCurso->curso->cod }} / {{ $periodoCurso->periodo->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Inscribir</button>
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
    document.getElementById('search-student-button').addEventListener('click', function() {
        const name = document.getElementById('student-search-name').value.toLowerCase();
        const lastName = document.getElementById('student-search-last-name').value.toLowerCase();
        const dni = document.getElementById('student-search-dni').value.toLowerCase();
        const code = document.getElementById('student-search-code').value.toLowerCase();

        const select = document.getElementById('student-select');
        const options = select.options;

        for (let i = 1; i < options.length; i++) {
            const option = options[i];
            const optionName = option.getAttribute('data-name').toLowerCase();
            const optionLastName = option.getAttribute('data-last-name').toLowerCase();
            const optionDni = option.getAttribute('data-dni').toLowerCase();
            const optionCode = option.getAttribute('data-code').toLowerCase();

            if (optionName.includes(name) && optionLastName.includes(lastName) && optionDni.includes(dni) && optionCode.includes(code)) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        }
    });

    document.getElementById('clear-search-button').addEventListener('click', function() {
        document.getElementById('student-search-name').value = '';
        document.getElementById('student-search-last-name').value = '';
        document.getElementById('student-search-dni').value = '';
        document.getElementById('student-search-code').value = '';

        const select = document.getElementById('student-select');
        const options = select.options;

        for (let i = 1; i < options.length; i++) {
            options[i].style.display = 'block';
        }
    });
</script>

@endsection