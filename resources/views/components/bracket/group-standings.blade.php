@props(['grupos'])

<div class="flex flex-col gap-2 w-44 shrink-0 me-4">
    <h3 class="text-light font-bold text-center tracking-wide">GRUPOS</h3>

    @foreach($grupos as $grupo)
        <div class="bg-complementary-primary border border-secondary rounded-2xl">
            <div class="uppercase bg-black rounded-t-2xl py-1 mb-2 font-bold text-center text-sm">
                Grupo {{ $grupo->name }}
            </div>
            <ul class="flex flex-col gap-1.5 px-3 pb-2">
                @foreach($grupo->equipos as $equipo)
                    <li class="flex items-center gap-2 text-light text-sm">
                        <img
                            src="{{ $equipo->imagen }}"
                            alt="{{ $equipo->nombre }}"
                            class="w-6 h-4 object-cover rounded shrink-0"
                        >
                        <span class="flex-1 truncate">{{ $equipo->nombre }}</span>
                        <span class="font-bold tabular-nums">{{ $equipo->puntos }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
