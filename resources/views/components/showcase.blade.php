@props([
'title',
'image'
])
{{-- {{ dd($image, str($image)->afterLast('showcase/')) }} --}}
<div {{ $attributes->merge([
    'class' => 'showcase'
    ]) }} style="background-image: url(images/showcase/blurred.jpg);
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;">
    <img src="{{ $image }}" alt="{{ $title }}" loading="lazy">
    <div class="body ">
        <div class="content d-flex flex-column px-2">
            <div>
                <h4 class="title">{{ $title }}</h4>
                <div class="description">{{ $slot }}</div>
            </div>
            <a href="{{ $image }}" target="__new"
                class="text-end text-white text-end w-100 text-decoration-none mt-2">Ver Imagen!</a>
        </div>
    </div>

    @push('scripts')
    <script>
        (function() {
                const images = document.querySelectorAll('.showcase img');

                images.forEach(img => {
                    
                    img.addEventListener("load", function(){
                        img.classList.add('loaded');
                   })
                });
            })()
    </script>
    @endpush
</div>