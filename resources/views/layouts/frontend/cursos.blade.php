@include('layouts.frontend.header')

<section id="cursos-mencion" class="py-5">
    <div class="container">
        <h2 class="text-center mb-4 display-4 font-weight-bold m-4 p-4">Mención en {{ $mencion }}</h2>

        <!-- Dividimos la descripción en dos párrafos -->
        <div class="row">
            <div class="col-md-8 offset-md-2">
                {{--<p class="text-center lead mb-4">--}}
                    {{--{{ Str::words($descripcion, 50, '...') }} <!-- Primeros 50 palabras del párrafo -->--}}
                {{--</p>--}}
                <p class="text-center lead">
                    {{ Str::after($descripcion, Str::words($descripcion, 50)) }} <!-- Resto del texto -->
                </p>
            </div>
        </div>

        <!-- Botón para volver -->
        <div class="text-center">
            <a href="{{ url('/') }}" class="btn btn-success mt-4">Volver a menciones</a>
        </div>
    </div>
</section>

@include('layouts.frontend.footer')
