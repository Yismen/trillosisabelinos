@props([
'name',
'title',
'image_url' => "https://ui-avatars.com/api/?name=" . $name
])
<div class="member" {{ $attributes->merge([
    'class' => 'member'
    ]) }}>
    <img src="{{ $image_url }}" alt="{{ $name }}">
    <h4 class="person">{{ $name }}</h4>
    <p class="title">{{ $title }}</p>
</div>