<section class="main_header container position-relative with-border" id="main_header">
    <div class="align-items-center flex-column justify-content-center row align-items-lg-end  py-lg-5 text-center text-lg-start "
        id="main_header_holder">
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
