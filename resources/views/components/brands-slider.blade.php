@props([
    'brands' => collect([]),
    'title' => 'Nuestros Patrocinadores',
])

@if($brands->isNotEmpty())
    @php 
        $sliderId = 'brands-swiper-' . uniqid();
    @endphp

    <h6 class="text-xl text-center font-semibold mb-4">{{ $title }}</h6>

    <div class="swiper {{ $sliderId }} w-full max-w-xl">
        <div class="swiper-wrapper py-2">
            @foreach($brands as $brand)
                <div class="swiper-slide">
                    @if(!empty($brand->url))
                        <a
                            href="{{ $brand->url }}"
                            target="_blank"
                            class="rounded-xl p-4 flex items-center justify-center h-full shadow-md shadow-black"
                            style="background-color: {{ $brand->background }};"
                        >
                            <img
                                src="{{ asset($brand->image) }}"
                                alt="{{ $brand->name }}"
                                class="w-full max-w-35 aspect-8/5 object-contain"
                            >
                        </a>
                    @else
                        <div
                            class="rounded-xl p-4 flex items-center justify-center h-full shadow-md shadow-black"
                            style="background-color: {{ $brand->background }};"
                        >
                            <img
                                src="{{ asset($brand->image) }}"
                                alt="{{ $brand->name }}"
                                class="w-full max-w-35 object-contain"
                            >
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <div class="{{ $sliderId }}-pagination mt-3 flex justify-center"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Swiper('.{{ $sliderId }}', {
                slidesPerView: 2,
                spaceBetween: 16,
                loop: true,
                centeredSlides: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.{{ $sliderId }}-pagination',
                    clickable: true,
                },
                breakpoints: {
                    640: { slidesPerView: 3 },
                    // 1520: { slidesPerView: 4 },
                },
            });
        });
    </script>
@endif
