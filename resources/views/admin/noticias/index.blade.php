@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
    <h2>Listado de Noticias</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Botón para agregar una nueva noticia -->
    <div class="mb-3">
        <a href="{{ route('admin.noticias.create') }}" class="btn btn-primary">Agregar Noticia</a>
    </div>

    </section>
    <section class="content">

    <table class="table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Fecha de Publicación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($noticias as $noticia)
            <tr>
                <td>{{ $noticia->titulo }}</td>
                <td>{{ $noticia->fecha_publicacion->format('d-m-Y') }}</td>
                <td>
                    <!-- Botón de Editar -->
                    <a href="{{ route('admin.noticias.edit', $noticia->id) }}" class="btn btn-warning">Editar</a>

                    <!-- Botón de Eliminar -->
                    <form action="{{ route('admin.noticias.destroy', $noticia->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </section>
</div>
@endsection
