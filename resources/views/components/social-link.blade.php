@props([
'title',
'icon',
'image_url',
'link_url',
])

<a href="{{ $link_url }}" target="__new" {{ $attributes->merge([
    'class' => 'text-black text-decoration-none d-flex flex-column justify-content-center align-items-center'
    ]) }}
    >
    <div class="align-items-center d-flex gap-2 mb-2">
        <i class="{{ $icon }}"></i>
        <span>{{ $title }}</span>
    </div>
    <img src="{{ $image_url }}" alt="{{ $title }}" class="social-image">
    {{-- <p class="fs-6 text-wrap" style="font-size: 0.75rem !important;">{{ $link_url }}</p> --}}
</a>