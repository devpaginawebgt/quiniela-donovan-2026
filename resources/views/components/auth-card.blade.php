<div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    {{-- Fondo responsive --}}
    <div class="fixed inset-0 -z-10 bg-cover bg-center bg-complementary-primary lg:hidden"
         style="background-image: url({{ asset('images/decoracion/main-bg.png') }});"></div>
    <div class="fixed inset-0 -z-10 bg-cover bg-center bg-complementary-primary hidden lg:block"
         style="background-image: url({{ asset('images/decoracion/bg-main-web.png') }});"></div>
    <div class="fixed inset-0 -z-10 bg-black/60"></div>

    <div class="w-full sm:max-w-xl p-6 h-auto bg-complementary-primary/80 shadow-md sm:rounded-lg overflow-y-auto">
        <div>
            <img
                src="/images/logos/logo-white.png"
                class="max-w-md"
                alt=""
            >
        </div>
        {{ $slot }}
    </div>
</div>
