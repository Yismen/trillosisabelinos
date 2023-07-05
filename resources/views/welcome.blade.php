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

<body id="inicio" data-bs-theme="light">
    @include('welcome.navigation')

    <div class="wrapper">
        @include('welcome.hero')

        @include('welcome.showcase')

        @include('welcome.social')

        @include('welcome.testimonials')

        @include('welcome.details')


        <section class="bg-primary text-white">
            <div class="container d-flex flex-column flex-md-row footer justify-content-between gap-5">
                <div class="text-center text-md-start">
                        <a href="#inicio" class="text-white text-decoration-none text-center text-md-start">
                            <h4 class="fw-bold fs-3">{{ config('app.name', 'Trillos Isabelinos') }}</h4>
                        </a>
                        <span><i class="fa fa-copyright"></i> 2023-{{ now()->format('Y') }}</span>
                </div>
                

                <div class="d-flex flex-column justify-content-center align-items-center gap-3">
                    <div class="contactos d-flex flex-column text-center">
                        <a href="mailto:trillosisabelinos@gmail.com" class="text-white"> <i class="fa fa-envelope"
                                target="__new"></i>
                            trillosisabelinos@gmail.com</a>
                        <a href="tel:+1-809-993-7940" class="text-white"><i class="fa fa-phone" target="__new"></i>
                            809-993-7940</a>
                    </div>
                    <div class=" socials d-flex gap-2">
                        <a
                            href="{{ config('app.trillos.links.instagram') }}"
                            target="__new"
                        >
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="{{ config('app.trillos.links.facebook') }}" target="__new">
                            <i class="fa-brands fa-facebook"></i>
                        </a>
                        <a href="{{ config('app.trillos.links.youtube') }}" target="__new">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @stack('scripts')

    @if(app()->isProduction())
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-74T5P7Y73B"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-74T5P7Y73B');
    </script>
    @endIf
</body>

</html>