@props(['premio'])

@php
    $trophyColor = match((int) $premio->posicion) {
        1 => '#EFBF04',
        2 => '#C4C4C4',
        3 => '#CE8946',
        default => '#FFFFFF',
    };
@endphp

<div
    class="prize-card bg-complementary-primary border border-secondary rounded-2xl overflow-hidden cursor-pointer hover:scale-[1.02] transition-transform duration-200 px-4 pb-4"
    data-nombre="{{ $premio->nombre }}"
    data-imagen="{{ asset($premio->imagen) }}"
    data-posicion="{{ $premio->posicion }}"
>
    {{-- Description hidden — used by JS for the modal --}}
    <span class="prize-card-descripcion hidden">{{ $premio->descripcion }}</span>

    <h3 class="text-lg font-semibold text-light text-center pt-2 mb-2">{{ $premio->titulo_posicion }}</h3>

    <div class="flex items-center gap-4">
        {{-- Position & Trophy --}}
        <div class="flex items-center gap-1 shrink-0 min-w-14">
            <span class="text-2xl font-bold" style="color: {{ $trophyColor }}">{{ $premio->posicion }}°</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" style="color: {{ $trophyColor }}">
                <path fill="currentColor" d="M19 5h-2V3H7v2H5c-1.1 0-2 .9-2 2v1c0 2.55 1.92 4.63 4.39 4.94.63 1.5 1.98 2.63 3.61 2.96V19H7v2h10v-2h-4v-3.1c1.63-.33 2.98-1.46 3.61-2.96C19.08 12.63 21 10.55 21 8V7c0-1.1-.9-2-2-2zM5 8V7h2v3.82C5.84 10.4 5 9.3 5 8zm14 0c0 1.3-.84 2.4-2 2.82V7h2v1z"/>
            </svg>
        </div>

        {{-- Info --}}
        <div class="flex-1 min-w-0">
            <p class="font-semibold text-light leading-tight">{{ $premio->nombre }}</p>
            <p class="text-complementary-light text-sm line-clamp-2 mt-0.5">{{ $premio->descripcion }}</p>
        </div>

        {{-- Arrow --}}
        <span class="flex items-center gap-1 shrink-0 font-semibold text-sm text-light ml-2">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </span>
    </div>
</div>
