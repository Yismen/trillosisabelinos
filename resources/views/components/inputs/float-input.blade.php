@props([
'type' => 'text',
'required' => true,
'label' => null,
'field',
])

{{-- <div class="form-floating mb-3">
    <input type="email" class="form-control" id="{{ $field }}" wire:model="{{ $field }}">
    <label for="{{ $field }}">{{ $slot }}:</label>
</div> --}}

<div class="form-floating mb-3">
    <input type="{{ $type }}" id="{{ $field }}" placeholder="{{ $slot }}" wire:model="{{ $field }}" {{
        $attributes->merge([
    'class' => 'form-control'
    ]) }}>
    <label for="{{ $field }}">{{ $slot }}:</label>
</div>