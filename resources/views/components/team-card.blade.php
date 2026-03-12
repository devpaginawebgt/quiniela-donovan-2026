@props(['equipo'])

<div
    class="team-card bg-complementary-primary border border-secondary rounded-2xl overflow-hidden cursor-pointer hover:scale-[1.02] transition-transform duration-200"
    data-nombre="{{ $equipo->nombre }}"
    data-imagen="{{ asset($equipo->imagen) }}"
>
    {{-- Description hidden — used by JS for the modal --}}
    <span class="team-card-descripcion hidden">{{ $equipo->descripcion }}</span>

    <div class="flex items-center gap-4 p-4">
        <img
            src="{{ asset($equipo->imagen) }}"
            alt="{{ $equipo->nombre }}"
            class="h-16 w-24 object-cover rounded-xl shrink-0 shadow-md"
        >
        <div class="flex-1 min-w-0">
            <p class="font-bold text-light leading-tight">{{ $equipo->nombre }}</p>
            <p class="text-complementary-light text-sm line-clamp-2 mt-0.5">{{ $equipo->descripcion }}</p>
        </div>
        <span class="flex items-center gap-1 shrink-0 font-semibold text-sm text-light ml-2">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </span>
    </div>
</div>
