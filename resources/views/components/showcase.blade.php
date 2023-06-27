@props([
'title',
'image'
])
<div {{ $attributes->merge([
    'class' => 'showcase'
    ]) }}>
    <img src="{{ $image }}" alt="{{ $title }}">
    <div class="body">
        <div class="content">
            <h4 class="title">{{ $title }}</h4>
            <div class="description">{{ $slot }}</div>
        </div>
    </div>
</div>