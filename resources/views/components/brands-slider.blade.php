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
            @for($i = 0; $i < 3; $i++)
                @foreach($brands as $brand)
                    <div class="swiper-slide">
                        <div class="bg-green-900/80 rounded-xl p-4 flex items-center justify-center h-full shadow-md shadow-black">
                            <img
                                src="{{ asset($brand->image) }}"
                                alt="{{ $brand->name }}"
                                class="w-full max-w-35 object-contain"
                            >
                        </div>
                    </div>
                @endforeach
            @endfor
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
