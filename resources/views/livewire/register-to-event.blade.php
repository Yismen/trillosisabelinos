<div class="shadow w-75">
    <div class="card card-body m-auto">
        <main class="form-signin">
            <form class="d-flex flex-column" wire:submit.prevent='create' id="registration_form">
                <img class="mb-4" src="/images/logo.png" alt="" width="150" height="57" style="align-self: center;">
                <h1 class=" h3 mb-3 fw-normal">Registrate en {{ $event->name }}</h1>

                <div class="row">
                    <div class="col-md-6">
                        <x-inputs.input field='name' label="Nombre Completo:" />
                    </div>
                    <div class="col-md-6">
                        <x-inputs.input field='phone' type="phone" label="Teléfono:" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <x-inputs.input field='email' type="email" :required=false label="Email:" />
                    </div>
                    <div class="col-md-6">
                        <x-inputs.input field='group' label="Grupo:" :required=false />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <x-inputs.input field='additional_phone' label="Teléfono Adicional:" :required=false />
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-inverse table-borderless table-sm">
                        <tbody>
                            @foreach ($event->plans as $plan)
                            <tr class="{{ isset($plans[$plan->id]) ? 'table-info' : '' }} align-baseline"
                                for="#quantity">
                                <td scope="row" class=" text-end fw-bold text-uppercase">{{ $plan->name }}</td>
                                <td class="">{{ $event->currency }} {{ $plan->price }} p/p</td>
                                <td class="">
                                    <x-inputs.inline-input type="number" field='plans.{{ $plan->id }}.quantity' min="0">
                                        Cantidad
                                    </x-inputs.inline-input>
                                </td>
                                <td class="">
                                    {{ $plan->currency }} {{
                                    number_format($this->calculateSubtotal(($plans[$plan->id]['quantity'] ?? 0),
                                    $plan->price), 2) }}
                                </td>
                                <td class="col-1">
                                    @if ($plans[$plan->id]['quantity'] ?? 0)

                                    <button class="btn btn-sm btn-dark" title="Eliminar"
                                        wire:click.prevent='clearProduct({{ $plan->id ?? 0 }})'>
                                        X
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                    </table>
                </div>

                @if ($errors->has('plans') )
                <div class="alert alert-danger fade show" role="alert">
                    <ul>
                        @foreach ($errors->get('plans') as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if ($errors->has('plans.*.quantity') )
                <div class="alert alert-danger fade show" role="alert">
                    <ul>
                        @foreach ($errors->get('plans.*.quantity') as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="text-end fs-5 fw-semibold">
                    $ {{ number_format($this->total, 2) }}
                </div>

                <div class="d-flex gap-3 flex-column flex-md-row justify-content-between mt-4">
                    <button class="btn btn-primary text-white" type="submit">Registrar</button>
                    <a href="/" class="btn btn-outline-dark" wire:click.prevent='cancel'>Cancelar</a>
                </div>
            </form>
        </main>
    </div>
    @push('scripts')
    <script>
        (function() {
            document.addEventListener("DOMContentLoaded", function(){
                let firstInput = $("#registration_form").find('input[type=text],textarea,select').filter(':visible:first');
                firstInput.focus();
            });     
        })()
    </script>
    @endpush

    @if(app()->isProduction())
    <!-- Google tag (gtag.js) -->
    @push('scripts')
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-1PFZ1SNWHL"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-1PFZ1SNWHL');
    </script>
    @endpush
    @endIf
</div>