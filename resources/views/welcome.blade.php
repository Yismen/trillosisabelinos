<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Yismen Jorge">
    <meta name="owner" content="Nicasio Suero">
    <meta name="content" content="Trillos Isabelinos">
    <meta name="description" content="Bicicleta de Trillos Republica Dominicana">
    <title>{{ config('app.name', 'Trillos Isabelinos') }}</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    @vite([
    'resources/js/app.js',
    'resources/sass/app.scss'
    ])
    @stack('styles')
</head>

<body id="inicio">
    <header class="navbar-light" id="navbar_top">
        <!-- Logo Nav START -->
        <nav class="navbar navbar-expand-lg  bg-white shadow">
            <div class="container">
                <!-- Logo START -->
                <a class="navbar-brand fw-bold text-success" href="#inicio">
                    <img class="light-mode-item navbar-brand-item w-50" src="{{ asset('images/logo.png') }}" alt="logo">
                    <span class="text-highlighted">{{ 2023 }}</span>
                </a>
                <!-- Logo END -->

                <!-- Responsive navbar toggler -->

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>


                <!-- Nav category menu START -->
                <div class="navbar-collapse collapse text-left" id="navbarNav">
                    <ul class="navbar-nav navbar-nav-scroll nav-pills-primary-soft  ms-auto p-2 p-xl-0">
                        <!-- Nav item Hotel -->
                        <li class="nav-item"> <a class="nav-link text-uppercase fs-5" href="#inicio">Inicio</a> </li>

                        <!-- Nav item Tour -->
                        <li class="nav-item"> <a class="nav-link text-uppercase fs-5" href="#showcase">Diversión</a>
                        </li>

                        <!-- Nav item Flight -->
                        <li class="nav-item"> <a class="nav-link text-uppercase fs-5" href="#redes">Síguenos</a>
                        </li>

                        <!-- Nav item Cabs -->
                        <li class="nav-item"> <a class="nav-link text-uppercase fs-5" href="#detalles">Detalles</a>
                        </li>
                        <a class="text-uppercase fs-5 btn btn-primary btn-sm text-white btn-group-vertical"
                            href="{{ config('app.trillos.links.inscripcion') }}">Inscribete</a>
                    </ul>

                    <ul class="navbar-nav navbar-nav-scroll nav-pills-primary-soft ms-auto p-2 p-xl-0 fs-4">
                        <li class="nav-item">
                            <a class="nav-link active text-primary" href="{{ config('app.trillos.links.facebook') }}"
                                aria-label="Facebook" target="__new" title="Facebook">
                                <i class="fa-brands fa-facebook"></i>
                                <span class="visible-md">Facebook</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-primary" href="{{ config('app.trillos.links.instagram') }}"
                                aria-label="Instagram" target="__new" title="Instagram">
                                <i class="fa-brands fa-instagram"></i>
                                <span class="visible-md">Instagram</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-primary" href="{{ config('app.trillos.links.youtube') }}"
                                aria-label="Youtube" target="__new" title="Youtube">
                                <i class="fa-brands fa-youtube"></i>
                                <span class="visible-md">Youtube</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Nav category menu END -->
            </div>
        </nav>
        <!-- Logo Nav END -->
    </header>

    <div class="wrapper">
        <section class="hero container position-relative with-border" id="hero">
            <div class="align-items-center flex-column justify-content-center row align-items-lg-end  py-lg-5 text-center text-lg-start "
                id="hero-holder">
                <h1 class="fw-bold my-3 mb-5 mb-lg-3  text-uppercase">
                    Trillos Isabelinos <span class="text-highlighted">2023</span>
                </h1>

                <a href="{{ asset('images/flyer-principal.jpeg') }}" class="poster" target="__new">
                    {{-- <a href="{{ config('app.trillos.links.inscripcion') }}" class="poster" target="__new"> --}}
                        <img src="{{ asset('images/flyer-principal.jpeg') }}" class="img-responsive w-100 shadow"
                            alt="Flyer Trillos">
                    </a>

                    <p class=" my-3 fs-4 fw-semibold">
                        Participa de la diversion y experiencia inolvidable del mejor evento ciclista del año!
                    </p>

                    <div class=" d-flex justify-content-center justify-content-center justify-content-lg-start">
                        <a href="{{ config('app.trillos.links.inscripcion') }}"
                            class="btn btn-primary text-white btn-lg text-uppercase shadow">Inscribete</a>
                    </div>
            </div>
        </section>

        {{-- <section class="container align-items-center justify-content-center py-4 redes" id="redes">
            <h3 class="title">No te pierdas, <span class="text-highlighted">Síguenos</span> siempre!</h3>

            <div class="text-black row content row">
                <x-social-link type="primary" class="col-sm-6 col-lg-3 mb-2" title="Formulario de Inscripción"
                    link_url="{{ config('app.trillos.links.inscripcion') }}" icon="fa-brands fa-google-drive"
                    :image_url="asset('images/qr-codes/form.png')" />


                <x-social-link type="primary" class="col-sm-6 col-lg-3 mb-2" title="Instagram"
                    link_url="{{ config('app.trillos.links.instagram') }}" icon="fa-brands fa-instagram"
                    :image_url="asset('images/qr-codes/instagram.png')" />

                <x-social-link type="primary" class="col-sm-6 col-lg-3 mb-2" title="Facebook"
                    link_url="{{ config('app.trillos.links.facebook') }}" icon="fa-brands fa-facebook"
                    :image_url="asset('images/qr-codes/facebook.png')" />

                <x-social-link type="primary" class="col-sm-6 col-lg-3 mb-2" title="Youtube"
                    link_url="{{ config('app.trillos.links.youtube') }}" icon="fa-brands fa-youtube"
                    :image_url="asset('images/qr-codes/form.png')" />
            </div>
        </section> --}}

        <section class="container showcases with-border" id="showcase">
            <h3 class="title">Pura Diversión, <span class="text-highlighted">Momentos</span> Inolvidables </h3>
            <div class="content row  py-3 justify-content-center align-items-center gap-3">

                <x-showcase class="col-sm-6 col-md-4 col-lg-3 mb-3 d-flex justify-content-center"
                    title="Equipo de Trabajo" :image="asset('images/showcase/equipo-4.jpg')">
                    Siempre listos, dedicados a servir, trato humano, calidad de primera.
                </x-showcase>
                <x-showcase class="col-sm-6 col-md-4 col-lg-3 mb-3 d-flex justify-content-center"
                    title="Equipo de Trabajo" :image="asset('images/showcase/equipo-2.jpg')">
                    Edicion 2019, los matatanes.
                </x-showcase>
                <x-showcase class="col-sm-6 col-md-4 col-lg-3 mb-3 d-flex justify-content-center"
                    title="Equipo de Trabajo" :image="asset('images/showcase/equipo-1.jpg')">
                    Siempre listos, dedicados a servir, trato humano, calidad de primera.
                </x-showcase>
                <x-showcase class="col-sm-6 col-md-4 col-lg-3 mb-3 d-flex justify-content-center" title="Nicky Suero"
                    :image="asset('images/showcase/banderazo-1.jpg')">
                    Palabras inaugurales y banderazo de salida.
                </x-showcase>
                <x-showcase class="col-sm-6 col-md-4 col-lg-3 mb-3 d-flex justify-content-center" title="Hay Mabí"
                    :image="asset('images/showcase/aneudy-disfrutando-un-mabi.jpg')">
                    Aneudy, disfrutando de un refrescante Mabi, bebida insignia de Trillos Isabelinos!
                </x-showcase>
                <x-showcase class="col-sm-6 col-md-4 col-lg-3 mb-3 d-flex justify-content-center" title="Cero Calor"
                    :image="asset('images/showcase/refrescantes-1.jpg')">
                    Refrescantes bebidas y abastecimientos de primera calidad!
                </x-showcase>
                <x-showcase class="col-sm-6 col-md-4 col-lg-3 mb-3 d-flex justify-content-center" title="Patron Bike!"
                    :image="asset('images/showcase/enmanuel-y-su-competidor-patron-bike.jpg')">
                    Enmanuel y su competidor de Patron Bike
                </x-showcase>
                <x-showcase class="col-sm-6 col-md-4 col-lg-3 mb-3 d-flex justify-content-center" title="Bicicentro!"
                    :image="asset('images/showcase/andres-valerio-representante-bicicentro.jpg')">
                    Andres Valerio, representando Bicicentro
                </x-showcase>
                <x-showcase class="col-sm-6 col-md-4 col-lg-3 mb-3 d-flex justify-content-center" title="Ciclon Bike!"
                    :image="asset('images/showcase/wendy-cruz-ciclon-bike-aneudy.jpg')">
                    Wendy Cruz, representando Ciclon Bike
                </x-showcase>
                <x-showcase class="col-sm-6 col-md-4 col-lg-3 mb-3 d-flex justify-content-center"
                    title="Momentos Inolvidables" :image="asset('images/showcase/momentos-1.jpg')">

                </x-showcase>
                <x-showcase class="col-sm-6 col-md-4 col-lg-3 mb-3 d-flex justify-content-center"
                    title="Momentos Inolvidables" :image="asset('images/showcase/momentos-2.jpg')">

                </x-showcase>
                <x-showcase class="col-sm-6 col-md-4 col-lg-3 mb-3 d-flex justify-content-center"
                    title="Momentos Inolvidables" :image="asset('images/showcase/momentos-3.jpg')">

                </x-showcase>
                <x-showcase class="col-sm-6 col-md-4 col-lg-3 mb-3 d-flex justify-content-center"
                    title="Momentos Inolvidables" :image="asset('images/showcase/momentos-4.jpg')">

                </x-showcase>
                <x-showcase class="col-sm-6 col-md-4 col-lg-3 mb-3 d-flex justify-content-center" title="Entre Amigos!"
                    :image="asset('images/showcase/entre-amigos-constanza.jpg')">
                    Grupo Entre Amigos de Constanza, siempre presentes
                </x-showcase>
                <x-showcase class="col-sm-6 col-md-4 col-lg-3 mb-3 d-flex justify-content-center" title="Imparables!"
                    :image="asset('images/showcase/imparables-navarrete.jpg')">
                    Grupo Imparables de Navarrete
                </x-showcase>
            </div>
        </section>

        <section class="container with-border" id="redes">
            <h3 class="title">No te pierdas, <span class="text-highlighted">Síguenos</span> siempre!</h3>
            <div class="row">
                <div class="col-md-3 d-flex flex-column">
                    <a href="{{ config('app.trillos.links.inscripcion') }}" rel="noopener noreferrer"
                        class="social-link">
                        <i class="fa-brands fa-google-drive"></i> Formulario Inscripcion
                    </a>
                    <a href="{{ config('app.trillos.links.instagram') }}" target="__new" rel="noopener noreferrer"
                        class="social-link">
                        <i class="fa-brands fa-google-drive"></i> Instagram
                    </a>
                    <a href="{{ config('app.trillos.links.facebook') }}" target="__new" rel="noopener noreferrer"
                        class="social-link">
                        <i class="fa-brands fa-google-drive"></i> Facebook
                    </a>
                    <a href="{{ config('app.trillos.links.youtube') }}" target="__new" rel="noopener noreferrer"
                        class="social-link">
                        <i class="fa-brands fa-google-drive"></i> Youtube
                    </a>
                </div>
                <div class="col-md-7">
                    <a href="{{ config('app.trillos.links.location') }}" target="__new">
                        <i class="fa fa-map-marker-alt mr-2"></i>
                        Punto de Partida: Kiandy Ranch
                    </a>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d176568.17490403846!2d-71.10994254861639!3d19.786854159974425!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8eb19b13c5debb5d%3A0x72bcecadca0cc82d!2sKiandy%20Ranch!5e0!3m2!1ses!2sdo!4v1687725053407!5m2!1ses!2sdo"
                        width="100%" height="360" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="col-md-2">
                    <div class="logos">
                        <img src="{{ asset('images/logos/logo.png') }}" alt="Trillos Isabelinos">
                        <img src="{{ asset('images/logos/patrulleros.jpeg') }}" alt="Patrulleros 121">
                        <img src="{{ asset('images/logos/yankees.png') }}" alt="Yankess">
                        <img src="{{ asset('images/logos/federacion.png') }}" alt="Federacion Nacional">
                    </div>
                </div>
            </div>
        </section>

        <section class="container testimonials">
            <h3 class="title">El que <span class="text-highlighted">sabe</span>, sabe!</h3>

            <div class="row content">
                <div class="col-sm-6 col-xl-3 mb-3">
                    <x-testimonial name="Andrés Valerio" title="Bicicentro">
                        Buena organización y puntualidad.
                        <x-slot name="footer">
                            Trillos Isabelinos 2018!
                        </x-slot>
                    </x-testimonial>
                </div>

                <div class="col-sm-6 col-xl-3 mb-3 mt-0 mt-xl-4">
                    <x-testimonial name="Aneudy el Brutal" title="Ciclista Paralímpico">
                        Me gustó el mabi en los abastecimientos, me sorprendieron en el Abastecimiento frío.
                        <x-slot name="footer">
                            Trillos Isabelinos 2019!
                        </x-slot>
                    </x-testimonial>
                </div>

                <div class="col-sm-6 col-xl-3 mb-3">
                    <x-testimonial name="Enmanuel" title="Patrón Bike">
                        Buena comida, buena organización, quedo mortal.
                        <x-slot name="footer">
                            Trillos Isabelinos 2018!
                        </x-slot>
                    </x-testimonial>
                </div>

                <div class="col-sm-6 col-xl-3 mb-3 mt-xl-4">
                    <x-testimonial name="Wendy Cruz" title="Ciclón Bile">
                        Un evento con calidad, hicieron buen trabajo.
                        <x-slot name="footer">
                            Trillos Isabelinos 2018!
                        </x-slot>
                    </x-testimonial>
                </div>
            </div>
        </section>


        <section class="bg-secondary" id="detalles">
            <h3 class="title">Fácil, <span class="text-highlighted">Adsequible</span>, Expectacular!</h3>
            <div
                class="align-items-sm-center align-items-start banner container d-flex flex-column gap-3 justify-content-between justify-content-md-center p-4">
                {{-- Info --}}
                <div class="d-flex justify-content-center gap-5 w-100">
                    <div class="">
                        <i class="fa fa-clock"></i>
                        <span class="fw-semibold">8:00 AM</span>
                    </div>
                    <div class="">
                        <i class="fa fa-map-marker-alt"></i>
                        <span class="fw-semibold">Kiandy Ranch</span>
                    </div>
                </div>

                {{-- main --}}
                <div class="d-flex flex-column flex-lg-row justify-content-between gap-5 w-100">
                    <div class="d-flex flex-column">
                        <h5 class="fw-bold text-uppercase text-center fs-5">Precios</h5>
                        <div class="d-flex justify-content-start shadow overflow-x-auto w-md-auto">
                            <ul class="list-group w-100">
                                <li class="list-group-item bg-transparent m-0 p-2">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <div class="text-uppercase fw-bold">
                                            Ciclistas
                                        </div>
                                        <div>
                                            <span class="fw-semibold">RD$</span>
                                            <span class="fw-bold fs-3">800</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item bg-transparent m-0 p-2">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <div class="text-uppercase fw-bold">
                                            Acompañantes
                                        </div>
                                        <div>
                                            <span class="fw-semibold">RD$</span>
                                            <span class="fw-bold fs-3">500</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item bg-transparent m-0 p-2">
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <div class="text-uppercase fw-bold">
                                            Niños (de 6 a 12)
                                        </div>
                                        <div>
                                            <span class="fw-semibold">RD$</span>
                                            <span class="fw-bold fs-3">300</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="fw-semibold mt-2 text-uppercase 5">
                            Niños menores de 6 años <span class="highlighted">Gratis</span>
                        </div>

                        <div>
                            <span class="badge bg-primary fw-light"><i class="fa fa-music"></i> DJ Envivo</span>
                            <span class="badge bg-primary fw-light"><i class="fa fa-water"></i> Piscina</span>
                            <span class="badge bg-primary fw-light"><i class="fa fa-ticket"></i> Rifas</span>
                            <span class="badge bg-primary fw-light"><i class="fa fa-zap"></i> Abastecimiento</span>
                            <span class="badge bg-primary fw-light"><i class="fa fa-face-laugh"></i> Almuerzo</span>
                        </div>

                    </div>

                    <div class="text-center">
                        {{-- <i class="fa fa-map-marker-alt"></i> --}}
                        <span class="fw-semibold text-uppercase">Para Depositos</span>

                        @include('cuentas-bancarias')
                    </div>
                </div>
                <div class="mx-auto mx-lg-0">
                    <a href="{{ config('app.trillos.links.inscripcion') }}"
                        class="btn btn-primary text-white shadow btn-lg">
                        Inscribete
                    </a>
                </div>
            </div>


    </div>
    </section>


    <section class="bg-primary text-white">
        <div
            class="align-items-md-end align-items-center container d-flex flex-column flex-md-row footer justify-content-between ">
            <div>
                <a href="#inicio" class="text-white text-decoration-none text-center text-md-start">
                    <h4 class="mb-5 fw-bold fs-3">{{ config('app.name', 'Trillos Isabelinos') }}</h4>
                </a>
                <div class="contactos mb-3 mb-md-0 d-flex flex-column text-center text-md-start">
                    <a href="mailto:trillosisabelinos@gmail.com" class="text-white"> <i class="fa fa-envelope"
                            target="__new"></i>
                        trillosisabelinos@gmail.com</a>
                    <a href="tel:+1-809-993-7940" class="text-white"><i class="fa fa-phone" target="__new"></i>
                        809-993-7940</a>
                </div>
            </div>

            <p class="legal d-flex flex-column mb-4 mb-md-0 ">
                Copyright 2023-{{ now()->format('Y') }}
                <span>Derechos reservados.</span>
            </p>

            <div class=" socials d-flex gap-2">
                <a href="{{ config('app.trillos.links.instagram') }}" target="__new"><i
                        class="fa-brands fa-instagram"></i></a>
                <a href="{{ config('app.trillos.links.facebook') }}" target="__new"><i
                        class="fa-brands fa-facebook"></i></a>
                <a href="{{ config('app.trillos.links.youtube') }}" target="__new"><i
                        class="fa-brands fa-youtube"></i></a>
            </div>
        </div>
    </section>
    </div>

    @stack('scripts')
    <script>
        (function(){
            document.addEventListener("DOMContentLoaded", function(){
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.getElementById('navbar_top').classList.add('fixed-top');
                // add padding top to show content behind navbar
                navbar_height = document.querySelector('.navbar').offsetHeight;
                document.body.style.paddingTop = navbar_height + 'px';
            } else {
                document.getElementById('navbar_top').classList.remove('fixed-top');
                // remove padding top from body
                document.body.style.paddingTop = '0';
            } 
        });
        }); 
        })()
    </script>

    @env('production')
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-74T5P7Y73B"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-74T5P7Y73B');
    </script>
    @endenv
</body>

</html>