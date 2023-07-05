

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