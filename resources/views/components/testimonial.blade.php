@props([
'name',
'title',
'footer',
'image_url' => "https://ui-avatars.com/api/?name=" . $name
])
<div class="testimonial h-100">
    <div class="header">
        <img src="{{ $image_url }}" alt="{{ $name }}">
        <div class="">
            <h4 class="person">{{ $name }}</h4>
            <p class="title">{{ $title }}</p>
        </div>
    </div>
    <div class="content">
        "{{ $slot }}"
        @isset($footer)
        <div class="footer">{{ $footer }}</div>
        @endisset
    </div>

</div>