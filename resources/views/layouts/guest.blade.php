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
    'resources/js/welcome.js',
    'resources/sass/welcome.scss'
    ])
    @stack('styles')
    @livewireStyles
</head>

<body>
    {{-- <header class="navbar-light" id="navbar_top">
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
                            href="{{ config('app.trillos.links.inscripcion') }}" target="__new">Inscribete</a>
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
    </header> --}}

    <div class="content align-items-center content d-flex justify-content-around"
        style="min-height: 100vh; background-color: rgb(0 150 136 / 12%);">
        {{ $slot }}
    </div>

    @livewireScripts
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
</body>

</html>
