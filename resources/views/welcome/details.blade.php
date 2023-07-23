<section class="bg-secondary" id="detalles">
    <h3 class="title animate">
        Fácil,
        <span class="text-highlighted">Adsequible</span>, Expectacular!
    </h3>
    <div
        class="align-items-sm-center align-items-start banner container d-flex flex-column gap-3 justify-content-between justify-content-md-center p-4 ">
        {{-- Info --}}
        <div class="d-flex justify-content-center gap-5 w-100 animate" data-delay=".15s">
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
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-5 w-100" data-delay=".25s">
            <div class="d-flex flex-column animate" data-delay=".25s">
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

            <div class="text-center animate" data-delay=".55s">
                {{-- <i class="fa fa-map-marker-alt"></i> --}}
                <span class="fw-semibold text-uppercase">Para Depositos</span>

                @include('cuentas-bancarias')
            </div>
        </div>
        <div class="mx-auto mx-lg-0 animate" data-delay=".4s" data-animation="slide-in-left">
            <a href="{{ config('app.trillos.links.inscripcion') }}"
                class="btn btn-primary text-white shadow btn-lg">
                Inscribete
            </a>
        </div>
    </div>
</section>
