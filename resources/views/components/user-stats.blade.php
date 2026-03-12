@props(['user'])

<div class="grid grid-cols-3 gap-3 py-6 max-w-lg mx-auto w-full">

    {{-- Puntos --}}
    <div class="flex flex-col items-center gap-2 bg-complementary-primary border border-secondary rounded-2xl py-4 px-2">
        <div class="bg-red-500 rounded-full p-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-light" viewBox="0 0 24 24" fill="currentColor">
                <path d="M13.5 0.67s.74 2.65.74 4.8c0 2.06-1.35 3.73-3.41 3.73-2.07 0-3.63-1.67-3.63-3.73l.03-.36C5.21 7.51 4 10.62 4 14c0 4.42 3.58 8 8 8s8-3.58 8-8C20 8.61 17.41 3.8 13.5.67zM11.71 19c-1.78 0-3.22-1.4-3.22-3.14 0-1.62 1.05-2.76 2.81-3.12 1.77-.36 3.6-1.21 4.62-2.58.39 1.29.59 2.65.59 4.04 0 2.65-2.15 4.8-4.8 4.8z"/>
            </svg>
        </div>
        <span class="text-xl font-bold">{{ $user->puntos ?? 0 }}</span>
        <span class="text-xs text-complementary-light text-center">Puntos</span>
    </div>

    {{-- Pronósticos --}}
    <div class="flex flex-col items-center gap-2 bg-complementary-primary border border-secondary rounded-2xl py-4 px-2">
        <div class="bg-red-500 rounded-full p-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-light" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
            </svg>
        </div>
        <span class="text-xl font-bold leading-tight">
            {{ $user->partidos->predicciones ?? 0 }}
            <span class="text-sm font-semibold text-complementary-light">/ {{ $user->partidos->total_partidos ?? 0 }}</span>
        </span>
        <span class="text-xs text-complementary-light text-center">Pronósticos</span>
    </div>

    {{-- Posición --}}
    <div class="flex flex-col items-center gap-2 bg-complementary-primary border border-secondary rounded-2xl py-4 px-2">
        <div class="bg-red-500 rounded-full p-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-light" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 5h-2V3H7v2H5c-1.1 0-2 .9-2 2v1c0 2.55 1.92 4.63 4.39 4.94.63 1.5 1.98 2.63 3.61 2.96V19H7v2h10v-2h-4v-3.1c1.63-.33 2.98-1.46 3.61-2.96C19.08 12.63 21 10.55 21 8V7c0-1.1-.9-2-2-2zM5 8V7h2v3.82C5.84 10.4 5 9.3 5 8zm14 0c0 1.3-.84 2.4-2 2.82V7h2v1z"/>
            </svg>
        </div>
        <span class="text-lg font-bold">
            {{ $user->posicion ? '#' . $user->posicion : '#N/A' }}
        </span>
        <span class="text-xs text-complementary-light text-center">Posición</span>
    </div>

</div>
