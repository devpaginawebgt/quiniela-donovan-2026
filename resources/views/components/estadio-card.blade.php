@props(['estadio'])

<div
    class="estadio-card bg-complementary-primary border border-secondary rounded-3xl overflow-hidden cursor-pointer hover:scale-[1.02] transition-transform duration-200"
    data-nombre="{{ $estadio->nombre }}"
    data-imagen="{{ asset($estadio->imagen) }}"
>
    <img
        src="{{ asset($estadio->imagen) }}"
        alt="{{ $estadio->nombre }}"
        class="w-full aspect-video object-cover"
    >

    {{-- Descripción completa (usada por JS para el modal) --}}
    <span class="estadio-descripcion hidden">{{ $estadio->descripcion }}</span>

    <div class="p-5 flex flex-col gap-2">
        <h3 class="font-bold text-xl leading-tight">{{ $estadio->nombre }}</h3>
        <p class="text-complementary-light text-sm line-clamp-1">{{ $estadio->descripcion }}</p>
        <div class="flex justify-end items-center mt-1">
            <span class="flex items-center gap-1 font-semibold text-sm text-light">
                Ver más
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </span>
        </div>
    </div>
</div>
