<div>
    <h6 class="fw-semibold">Proceso de registro ha sido satisfactorio!</h6>

    <p>
        proceder a realizar el pago correspondiente por el monto de <span class="fw-semibold">RD$</span> <span
        class="fw-bold fs-4">{{ number_format($total, 2) }}</span> PESOS
        @foreach ($sales as $sale)
            <span class="badge bg-primary">
                {{ $sale->plan->name }} - {{ $sale->count }}
            </span>
        @endforeach
    </p>

    @include('cuentas-bancarias')
</div>
