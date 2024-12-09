@extends('layouts.app')

@section('content')
<div class="content-wrapper">

  <section class="content-header">
    <h2>Crear Noticia</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  </section>

  <section class="content">
    <form action="{{ route('admin.noticias.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="titulo">Título de la noticia</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo') }}" required>
        </div>

        <div class="form-group">
            <label for="contenido">Contenido</label>
            <textarea class="form-control" id="contenido" name="contenido" rows="5" required>{{ old('contenido') }}</textarea>
        </div>

        <div class="form-group">
            <label for="enlace1">Primer enlace (opcional)</label>
            <input type="url" class="form-control" id="enlace1" name="enlace1" value="{{ old('enlace1') }}">
        </div>

        <div class="form-group">
            <label for="enlace2">Segundo enlace (opcional)</label>
            <input type="url" class="form-control" id="enlace2" name="enlace2" value="{{ old('enlace2') }}">
        </div>

        <div class="form-group">
            <label for="fecha_publicacion">Fecha de publicación</label>
            <input type="date" class="form-control" id="fecha_publicacion" name="fecha_publicacion" value="{{ old('fecha_publicacion') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Crear Noticia</button>
    </form>


  </section>
</div>
@endsection
