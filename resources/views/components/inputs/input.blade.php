@props([
'type' => 'text',
'required' => true,
'label' => null,
'field',
])
<div class="mb-3">
    @if ($label)
    <x-inputs.label :field="$field" :required="$required" :label="$label" />
    @endif

    <input type="{{ $type }}" id="{{ $field }}" aria-describedby="{{ $field }}Help" wire:model='{{ $field }}' {{
        $attributes->class([
    'form-control',
    'is-invalid' => $errors->has($field)
    ])->merge([
    ]) }}
    >

    <x-inputs.error :field="$field" />
</div>