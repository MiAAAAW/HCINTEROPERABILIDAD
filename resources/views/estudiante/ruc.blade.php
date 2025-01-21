@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-purple1">RUC</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-blue text-white">
                            <h3 class="card-title"></h3>
                            <div class="d-flex justify-content-between">
                                <p class="mb-0">Nombre: {{ Auth::user()->name }} {{ Auth::user()->last_name }}</p>
                                <p class="mb-0">Código: {{ Auth::user()->codigo }}</p>

                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-purple3 text-white text-center">
                                    <tr>
                                        <th>Código</th>
                                        <th>Curso</th>
                                        <th>PP1</th>
                                        <th>PP2</th>
                                        <th>PP3</th>
                                        <th>Promedio Final</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $currentPeriodo = null;
                                        $currentMension = null;
                                    @endphp

                                    @foreach($notas as $nota)
                                        @if($currentPeriodo != $nota->periodoCurso->periodo->name)
                                            @php
                                                $currentPeriodo = $nota->periodoCurso->periodo->name;
                                                $currentMension = null; // Resetear la mención al cambiar el periodo
                                            @endphp
                                            <tr>
                                                <td colspan="7" class="bg-purple2 text-white text-center">
                                                    <h5 class="mb-0">Periodo: {{ $currentPeriodo }}</h5>
                                                </td>
                                            </tr>
                                        @endif

                                        @if($currentMension != $nota->periodoCurso->curso->mension)
                                            @php
                                                $currentMension = $nota->periodoCurso->curso->mension;
                                            @endphp
                                            <tr>
                                                <td colspan="7" class="text-purple4">
                                                    <h6 class="mb-0">Mención: {{ $currentMension }}</h6>
                                                </td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <td>{{ $nota->periodoCurso->curso->cod }}</td>
                                            <td>{{ $nota->periodoCurso->curso->name }}</td>
                                            <td>{{ $nota->nota1 }}</td>
                                            <td>{{ $nota->nota2 }}</td>
                                            <td>{{ $nota->nota3 }}</td>
                                            <td>{{ $nota->promedio }}</td>
                                            <td>
                                                @if($nota->aprobado == 'Aprobado')
                                                    <span class="badge badge-success">Aprobado</span>
                                                @elseif($nota->aprobado == 'Desaprobado')
                                                    <span class="badge badge-danger">Desaprobado</span>
                                                @else
                                                    <span class="badge badge-warning">En proceso</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
