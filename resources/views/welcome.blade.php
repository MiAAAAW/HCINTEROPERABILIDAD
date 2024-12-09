@include('layouts.frontend.header')



<section id="inicio" class="section-main-box">

    {{-- box-main --}}
    <div class="main-box">
        <div class="row">
            <div class="myMainSwiper ">
                <div class="main-box-div-1">
                    <div class="main-box-text">
                        {{-- <img class="animate__animated animate__backInDown animate__delay-2s" src="{{ url('public/assets/imgs/medicinaLogo.png') }}" alt=""
                            width="150px"> --}}
                        <h1 class="animate__animated animate__backInDown animate__delay-2s">PIDE</h1>
                        <h1 class="text-writer animate__animated animate__backInDown animate__delay-2s">Plataforma Nacional</h1>
                        <h1 class="text-writer animate__animated animate__backInDown animate__delay-2s">De Interoperabilidad</h1>
                        <p class="animate__animated animate__backInDown animate__delay-2s">¡Bienvenidos al Portal del Interoperabilidad de El Collao Ilave!
                        </p>
                        <div class="main-box-btns animate__animated animate__backInDown animate__delay-2s">
                            <span>
                                <a href="{{url('login')}}" class="main-btns-1">Ingresar</a>
                            </span>
                            {{-- <span>
                                <a href="#" class=" main-btns-1 color-white">Ver Más</a>
                            </span> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



{{-- section logos --}}
{{-- <section id="" class="section-logos">
    <div class="container py-3">
        <div class="firts-slider-logos">
            <div class="first-slider-text">
                <h2>Acreditados por:</h2>
            </div>
            <div class="swiper logoSwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img class="img-fluid" src="{{ url('public/assets/imgs/logoUnap.png') }}" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img class="img-fluid" src="{{ url('public/assets/imgs/conareme.png') }}" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img class="img-fluid" src="{{ url('public/assets/imgs/aspefam.png') }}" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img class="img-fluid" src="{{ url('public/assets/imgs/essalud.png') }}" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img class="img-fluid" src="{{ url('public/assets/imgs/minsa.png') }}" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img class="img-fluid" src="{{ url('public/assets/imgs/sunedu.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}

{{-- seciton info  --}}

{{-- <section id="informacion" class="section-info-med py-5 bg-gray">
    <div class="container ">
        <div class="row">
            <!-- Div para el texto -->
            <div class="col-md-6 info-container-3-text animate__animated animate__fadeInLeft">
                <h2 class="color-purple2 font-title2 animate__animated animate__fadeInLeft">¿Qué es el Residentado Medico?</h2>
                <p>El residentado médico es un programa académico diseñado para médicos recién graduados que desean
                    especializarse en una disciplina específica de la medicina. Durante este período de formación
                    intensiva, los residentes trabajan bajo la supervisión de profesionales experimentados en hospitales
                    o instituciones de salud reconocidas. El objetivo principal del residentado es proporcionar una
                    educación práctica y teórica avanzada que prepare a los médicos para ejercer de manera competente en
                    su especialidad elegida. Este proceso de aprendizaje incluye rotaciones en diversas áreas médicas,
                    participación en procedimientos clínicos y quirúrgicos, así como la oportunidad de desarrollar
                    habilidades de investigación y gestión en salud. Al completar con éxito su programa de residentado,
                    los médicos obtienen la certificación necesaria para ejercer oficialmente como especialistas en su
                    campo, contribuyendo así al avance y la calidad del cuidado médico en beneficio de la comunidad.
                </p>
            </div>

            <!-- Div para la imagen (visible solo en escritorio) -->
            <div class="col-md-6 d-none d-md-block ">
                <div class="second-box-img p-auto animate__animated animate__fadeInRight">
                    <img src="{{ url('public/assets/imgs/doc1.png') }}" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </div>
</section> --}}

{{-- mensiones second --}}


{{--
<section class="py-5">

    <div class="container py-5">
        <div class="row four-box-container">
            <div class="col-md-6"> --}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-6 four-box-figure-1">--}}
{{--                        <div class="container a-img-1" style="height: 100%"></div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-6">--}}
{{--                        <div class="row four-box-imgs">--}}
{{--                            <div class="col-md-6 four-box-info-container">--}}
{{--                                <div class="four-container-boxs">--}}
{{--                                    <div class="four-box four-box-info-1">--}}
{{--                                        <div class="">--}}
{{--                                            <a class="">+ 8</a>--}}
{{--                                            <a class="">Menciones para elegir.</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class=" four-box four-box-info-2">--}}
{{--                                        <div class="">--}}
{{--                                            <a class="">+ 260</a>--}}
{{--                                            <a class="">Profesionales.</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-6 four-box-figure-2">--}}
{{--                                <div class="container border"></div>--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                {{-- <div class="container">
                    <img src="{{ url('public/assets/imgs/img10.png') }}"  class="img-fluid">
                </div>
            </div>
            <div class="col-md-6 py-5">
                <div class="four-box-main-info">
                    <h2 class="font-title2 color-purple2">Estudia con Nosotros</h2>
                    <p class="py-3">En nuestro programa de residentado médico, diseñado para médicos recién graduados
                        en busca de especialización, te ofrecemos una experiencia integral y enriquecedora. Con mentoría
                        personalizada de expertos destacados, rotaciones clínicas avanzadas, acceso a tecnología médica
                        de última generación y oportunidades para participar en
                        investigación innovadora, te preparamos no solo para sobresalir en tu especialidad elegida, sino
                        también para contribuir significativamente al avance del campo médico.</p>
                    <p class=""> <i class="bi bi-patch-check-fill color-blue "></i> Enfoque en desarrollo
                        individualizado.</p>
                    <p class=""> <i class="bi bi-patch-check-fill color-blue "></i> Experiencia práctica en
                        entornos variados.</p>
                    <p class=""> <i class="bi bi-patch-check-fill color-blue "></i> Integración de conocimientos
                        médicos especializados.</p>
                    <p class="pt-4">
                        <a href="#menciones" class="four-box-btn four-box bg-purple2 color-white">Ver Más</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section> --}}



{{--meciones--}}

{{-- <section id="menciones" class="bg-news py-5 section-mencion">
    <div class="container">
        <h2 class="text-center color-white mb-4 animate__animated animate__bounce">Menciones</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 ag-courses_box">

            @foreach ($menciones as $mencion)
                <div class="col px-4 ag-courses_item">
                    <a href="{{ route('mencion.cursos', Str::slug($mencion)) }}" class="ag-courses-item_link">
                        <div class="ag-courses-item_bg"></div>
                        <div class="ag-courses-item_title">{{ $mencion }}</div>
                        <div class="ag-courses-item_date-box">
                            Ver
                            <span class="ag-courses-item_date">Más</span>
                        </div>
                    </a>
                </div>
            @endforeach

        </div>
    </div>
</section> --}}


{{--    start eventos section--}}
    <!-- resources/views/home.blade.php -->

{{-- <section class="py-5">
<div class="py-5 content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Swiper container -->
            <div class="swiper-container gallerySwiper">
                <div class="swiper-wrapper">
                    @if(count($images) > 0)
                        @foreach($images as $image)
                            <!-- Cada imagen se convertirá en un slide de Swiper -->
                            <div class="swiper-slide box-flayer">
                                    <img src="{{ url('public/storage/images/' . basename($image)) }}" alt="Imagen subida" class="flayer-img">
                                </div>
                        @endforeach
                    @else
                        <p>No hay imágenes disponibles.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

</section>
 --}}


{{--    end eventos section --}}



{{--noticias--}}

{{--<section id="noticias" class="py-5 bg-gray">
    <div class="container">
        <h2 class="text-center color-purple2 pb-5">Noticias</h2>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($noticias as $noticia)
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        //comentado<p class="card-text"><small class="text-muted">Publicado el {{ $noticia->fecha_publicacion->format('d de F, Y') }}</small></p>
                        <p class="card-text"><small class="text-muted">Publicado el {{ $noticia->fecha_publicacion->format('d \d\e F, Y') }}</small></p>
                        <h5 class="card-title">{{ $noticia->titulo }}</h5>
                        <p>{{ $noticia->contenido }}</p>
                        @if ($noticia->enlace1)
                            <p><a href="{{ $noticia->enlace1 }}">Ver más</a></p>
                        @endif
                        @if ($noticia->enlace2)
                            <p><a href="{{ $noticia->enlace2 }}">Enlace adicional</a></p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>--}}



{{-- section para enviar lo que es flayers --}}


{{-- preguntas frecuentes --}}
{{-- <section id="preguntas" class="py-5">
    <div class="container">
        <h2 class="text-center mb-4 color-purple2 animate__animated animate__bounce">Preguntas frecuentes</h2>
        <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        ¿Cuáles son los requisitos para ingresar al programa de residentado médico en la UNA-Puno?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Escribenos al correo electronico residentadomedicounap@gmail.com
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        ¿Cuáles son las especialidades médicas que ofrece la UNA-Puno?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Ver en la seccion de mensiones.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        ¿Cuál es la duración del programa de residentado médico en la UNA-Puno?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <a href="https://www.conareme.org.pe/web/Documentos/Admision2024/cronograma%20exun%202024%20-%20FORMATO%20-%20MODIF%2027%20MARZO.pdf">Ver aqui</a>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        ¿Cuáles son las instalaciones y recursos disponibles para los residentes médicos?
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Las instalaciones de la UNA-Puno para residentes médicos incluyen laboratorios equipados, bibliotecas especializadas y acceso a hospitales asociados para prácticas clínicas.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        ¿Si soy estudiante del residentado como puedo ver mis notas?
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Revise su bandeja de entrada de correro electronico,<br>
                        Acerquese a la oficina de segunda residentado medico en la Universidad Nacional del Altiplano
                    </div>
                </div>
            </div>
        </div>
    </div>

</section> --}}



{{-- section de video --}}
{{-- <section class="section-video"> --}}
{{--
</section> --}}

{{-- seccion para contactos --}}
{{-- <section id="contactos" class="section-contact border-0">

    <div class="container">
        <div class="row container-box-contant px-4">
            <div class="col-md-6">
                <!-- Segundo div -->
                <div class="s-box-contanct">
                    <h2>Contactanos</h2>
                    <form class="s-form-contact" action="" method="POST">
                        <div class="">
                            <input placeholder="Correo Electronico" type="email" class="form-control"
                                id="correo" name="correo" required>
                        </div>
                        <a class="btn btn-dark" href="{{ url('sendemail') }}">Enviar</a>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <!-- Primer div -->
                <div class="s-box-text-contanct">
                    <p><i class="bi bi-envelope"></i> Email: redidenstadomedico@gmail.com</p>
                    <p><i class="bi bi-headset"></i> Telefono: 93771774</p>
                    <p><i class="bi bi-clock"></i> Atencion: Lunes a Viernes(9:00 am - 2:00 pm)</p>
                </div>
            </div>
        </div>
    </div>

</section> --}}



@include('layouts.frontend.footer')
