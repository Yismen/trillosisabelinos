@props([
'type' => 'text',
'required' => true,
'field',
])
<div class=" mb-3">
    <div class="row g-3 align-items-center">
        <div class="col-auto">
            <x-inputs.label :field="$field" :required="$required" :label="$slot" />
        </div>

        <div class="col-auto">
            <input type="{{ $type }}" id="{{ $field }}" aria-describedby="{{ $field }}Help" wire:model='{{ $field }}' {{
                $attributes->class([
            'form-control',
            'is-invalid' => $errors->has($field)
            ])->merge([
            ]) }}
            >
        </div>
        <x-inputs.error :field="$field" />
    </div>