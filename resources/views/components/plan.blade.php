@props([
'name',
'price',
'currency' => 'RD$',
'main' => false
])
<div class="d-flex flex-column {{ $main ? 'border shadow' : '' }}">
    <div class="d-flex text-nowrap text-center p-2">
        <span class="fw-semibold fs-5">{{ $currency }}</span>
        {{-- <span class="fw-bold {{ $main ? 'fs-1' : 'fs-2' }}">{{ $price }}</span> --}}
        <span class="fw-bold fs-2">{{ $price }}</span>
    </div>
    {{-- <div class="{{ $main ? 'bg-secondary text-white' : 'bg-primary' }} text-nowrap text-uppercase p-2 fw-semibold">
        --}}
        <div class="bg-primary text-center text-nowrap text-uppercase p-2 fw-semibold">
            {{ $name }}
        </div>
        <div>
            <ul class="text-nowrap">
                <li class="list-group-item"> <i class="fa fa-check"></i> Piscina </li>
                <li class="list-group-item"> <i class="fa fa-check"></i> Almuerzo </li>
                @if ($main)
                <li class="list-group-item"> <i class="fa fa-check"></i> Abastecimiento </li>
                <li class="list-group-item"> <i class="fa fa-check"></i> Rifas </li>
                <li class="list-group-item"> <i class="fa fa-check"></i> Muchas Sorpresas </li>
                @endif
            </ul>
        </div>
    </div>