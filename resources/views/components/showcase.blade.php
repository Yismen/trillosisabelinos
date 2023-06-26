@props([
'title',
'image'
])
<div {{ $attributes->merge([
    ]) }}>
    <div class="showcase">
        <div class="showcase-body">
            <h4 class="title">{{ $title }}</h4>
            <div class="description">{{ $slot }}</div>
        </div>
    </div>
</div>

@pushOnce('scripts', 'showcase-css')
<style>
    .showcase .title {
        text-align: center;
        font-weight: 700;
    }

    .showcase .description {
        font-size: 0.75rem;
        letter-spacing: 1px;
        margin: 20px 0 0 0;
    }

    .showcase {
        padding: 0 20px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        /* gap: 10px; */
        justify-content: center;
        align-items: center;
        color: white;
        background-image: url({{ $image }});
        background-size: cover;
        background-position: center;
        background-repeat: none;
        height: 150px;
        /* width: 250px; */
        width: auto;
        /* height: auto; */
        transition: 0.5s;
    }

    .showcase:hover {
        box-shadow: inset 0 0 0 200px rgba(0, 0, 0, 0.6);
        cursor: pointer;
    }

    .showcase-body {
        opacity: 0;
        transform: scale(0);
        transition: 0.8s;
    }

    .showcase:hover .showcase-body {
        opacity: 1;
        transform: scale(1);
    }
</style>
@endPushOnce