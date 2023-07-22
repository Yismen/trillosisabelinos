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
                    <li class="nav-item"> <a class="nav-link text-uppercase fs-5" href="#main_header">Inicio</a> </li>

                    <!-- Nav item Tour -->
                    <li class="nav-item"> <a class="nav-link text-uppercase fs-5" href="#showcase">Diversión</a>
                    </li>

                    <!-- Nav item Flight -->
                    <li class="nav-item"> <a class="nav-link text-uppercase fs-5" href="#redes">Síguenos</a>
                    </li>

                    <!-- Nav item Cabs -->
                    <li class="nav-item"> <a class="nav-link text-uppercase fs-5" href="#detalles">Detalles</a>
                    </li>
                    <a class="text-uppercase fs-5 btn btn-primary btn-sm text-white btn-group-vertical ms-0 ms-md-3"
                        href="{{ config('app.trillos.links.inscripcion') }}">Inscribete</a>
                </ul>

                <ul class="navbar-nav navbar-nav-scroll nav-pills-primary-soft ms-auto p-2 p-xl-0 fs-4">
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="{{ config('app.trillos.links.facebook') }}"
                            aria-label="Facebook" target="__new" title="Facebook">
                            <i class="fa-brands fa-facebook"></i>
                            <span class="visible-md">Facebook</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="{{ config('app.trillos.links.instagram') }}"
                            aria-label="Instagram" target="__new" title="Instagram">
                            <i class="fa-brands fa-instagram"></i>
                            <span class="visible-md">Instagram</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="{{ config('app.trillos.links.youtube') }}"
                            aria-label="Youtube" target="__new" title="Youtube">
                            <i class="fa-brands fa-youtube"></i>
                            <span class="visible-md">Youtube</span>
                        </a>
                    </li>
                </ul>


                <ul class="navbar-nav navbar-nav-scroll nav-pills-primary-soft  ms-0 ms-md-3">
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="/admin"
                            aria-label="Admin"  title="Admin">
                            <i class="fa fa-arrow-right-from-bracket"></i>
                            <span class="visible-md">Admin</span>
                        </a>
                    </li>
                </ul>

                {{-- <ul class="navbar-nav navbar-nav-scroll nav-pills-primary-soft ms-auto p-2 p-xl-0 fs-4">
                    <li class="nav-item dropdown">
                        <button class="btn btn-link nav-link py-2 px-0 px-lg-2 dropdown-toggle d-flex align-items-center show" id="bd-theme" type="button" aria-expanded="true" data-bs-toggle="dropdown" data-bs-display="static" aria-label="Toggle theme (dark)">

                        <span class="d-lg-none ms-2" id="bd-theme-text">Toggle theme</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end show px-2" aria-labelledby="bd-theme-text" data-bs-popper="static">
                            <li>
                                <a href="/admin" title="Admin" class="text-dark d-flex">
                                    <i class="fa fa-arrow-right-from-bracket"></i> Admin
                                </a>
                            </li>
                            <li class="divider">
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                                    <i class="fa fa-sun"></i>
                                    Light
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="true">
                                    <i class="fa fa-moon"></i>
                                    Dark
                                </button>
                            </li>
                        </ul>
                    </li>
                </ul> --}}

            </div>
            <!-- Nav category menu END -->
        </div>
    </nav>
    <!-- Logo Nav END -->

    @push('scripts')

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
    @endpush
</header>
