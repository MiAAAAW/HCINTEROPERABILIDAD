<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>El Collao Ilave</title>
    <link rel="shortcut icon" href="{{ asset('assets/imgs/iconcollao.png') }}" type="image/x-icon">
    {{-- <link rel="shortcut icon" href="{{url('public/assets/imgs/logoUnap.png')}}" type="image/x-icon"> --}}

    {{-- boostrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- google fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">

    {{-- slick carousel --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    {{--    liberia de animacion--}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />

    {{-- own styles
    <link rel="stylesheet" href="{{ url('public/dist/css/app.css') }}">
    <link rel="stylesheet" href="{{ url('public/dist/css/welcome.css') }}">
    <link rel="stylesheet" href="{{ url('public/dist/css/laptop.css') }}">
    <link rel="stylesheet" href="{{ url('public/dist/css/screen2.css') }}"> --}}

    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/screen2.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/laptop.css') }}">

</head>

<body>


<section class="section-navbar bg-blue">
    <div class="container">
        {{-- navbar --}}
        <nav class="navbar navbar-expand-lg  py-3">
            <div class="container-fluid bg-blue">
                <a class="navbar-brand color-white font-title2 " href="#">
                    <img class="logo-navbar" src="{{ url('public/assets/imgs/logoUnap.png') }}" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-navbar text-white"><i class="bi bi-list"></i></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
                        <li class="nav-item">
                            <a class="nav-link color-white" aria-current="page" href="{{url('/')}}#inicio">Inicio</a>
                        </li>
                        {{-- <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle color-white" href="#" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                Información
                            </a>
                            <ul class="dropdown-menu bg-light">
                                <li><a class="dropdown-item color-purple2" href="{{ url('/') }}#informacion ">Información</a>
                                </li>
                                <li><a class="dropdown-item color-purple2" href="{{ url('mision') }}">Misión y
                                        Visión</a></li>

                                <li><a class="dropdown-item color-purple2" href="{{ url ('historia') }}">Historia</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link color-white" aria-current="page"
                               href="{{url('/')}}#noticias">Noticias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link color-white" href="{{url('/')}}#menciones">Menciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link color-white" aria-current="page" href="{{url('/')}}#contactos">Contactanos</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link color-white" href="{{ url('login') }}">Ingresar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

</section>
