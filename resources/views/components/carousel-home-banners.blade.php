{{--
    Carousel de banners para la página principal (proximos-partidos).
    Usa Swiper.js con autoplay (4000ms) y paginación por dots.
    Aspect ratio: 1080/660 (móvil) | 1920/700 (lg+)

    @param \Illuminate\Support\Collection $banners - Colección de banners con url, url_web y name
--}}
@props(['banners'])

@if($banners->isNotEmpty())
<div class="relative w-full bg-complementary-primary">
    <div class="swiper carousel-home-banners w-full max-w-480 mx-auto aspect-1080/660 lg:aspect-1920/700">
        <div class="swiper-wrapper">
            @foreach($banners as $banner)
            <div class="swiper-slide">
                <picture class="block w-full h-full">
                    <source media="(min-width: 1024px)" srcset="{{ asset($banner->url_web) }}">
                    <img src="{{ asset($banner->url) }}" class="block w-full h-full object-cover pointer-events-none" alt="{{ $banner->name }}">
                </picture>
            </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.carousel-home-banners', {
        loop: true,
        autoplay: { delay: 4000, disableOnInteraction: false },
        pagination: { el: '.carousel-home-banners .swiper-pagination', clickable: true },
    });
});
</script>
@endif
