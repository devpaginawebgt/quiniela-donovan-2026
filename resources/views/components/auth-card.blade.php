<div
    class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-auth bg-dark"
    style="background-image: url({{ asset('images/fondo-azul.png') }});"
>

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
