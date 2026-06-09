<x-admin-layout>
    <div class="max-w-screen-2xl 2xl:w-screen-2xl mx-auto h-full flex-1 flex justify-center items-start py-6">

        @can('manage match polling')
            <section class="w-full rounded-2xl bg-complementary-primary backdrop-blur shadow-lg py-4 sm:py-6 px-4 sm:px-6 mb-6">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
                    <div class="flex items-center gap-3">
                        <span class="icon-[material-symbols--scoreboard-outline-rounded] w-6 h-6 lg:w-8 lg:h-8 text-secondary shrink-0"></span>
                        <h2 class="font-semibold text-light text-lg lg:text-2xl">Agendar notificación de marcador</h2>
                    </div>

                    <a href="{{ route('web.admin.match-score-requests.index') }}"
                       class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-teal-700 text-light hover:brightness-110 transition-colors">
                        <span class="icon-[material-symbols--arrow-back-rounded] w-5 h-5"></span>
                        Volver
                    </a>
                </div>

                <x-toast-errors :errors="$errors" />

                @if ($grouped->isEmpty())
                    <div class="rounded-xl border border-complementary-dark/30 bg-primary/20 p-6 text-center text-sm text-complementary-light">
                        No hay partidos elegibles para agendar.
                        <p class="mt-2 text-xs">Sólo se listan jornadas con al menos un partido pendiente de jugarse.</p>
                    </div>
                @else
                    <form action="{{ route('web.admin.match-score-requests.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <p class="text-sm text-complementary-light">
                            Filtra una jornada y selecciona los partidos cuyo marcador quieres notificar. La sincronización se realiza cada 5 minutos a partir de que inicia el partido.
                        </p>

                        {{-- Select de jornadas --}}
                        <div class="flex flex-col sm:flex-row gap-2 text-center items-center justify-center">
                            <select
                                id="jornada-select"
                                class="w-full md:max-w-md py-2.5 px-3 text-sm rounded-lg bg-light text-dark border border-complementary-dark/30 focus:ring-secondary focus:border-secondary"
                            >
                                <option value="">Selecciona una jornada…</option>
                                @foreach ($grouped as $jornadaNombre => $partidos)
                                    <option value="{{ $jornadaNombre }}">{{ $jornadaNombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Grupos de partidos (uno por jornada, ocultos hasta selección) --}}
                        @foreach ($grouped as $jornadaNombre => $partidos)
                            <div data-jornada="{{ $jornadaNombre }}"
                                 class="js-jornada-group rounded-xl border border-complementary-dark/30 bg-primary/15 p-4 hidden">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="font-semibold text-light">{{ $jornadaNombre }}</h3>
                                    
                                    {{-- <button type="button"
                                            class="js-select-group text-xs text-secondary hover:underline"
                                            data-group="{{ $loop->index }}">
                                        Seleccionar todos
                                    </button> --}}
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    @foreach ($partidos as $partido)
                                        @php
                                            $nombre1 = $partido->equipos?->equipoUno?->nombre ?? 'Equipo 1';
                                            $nombre2 = $partido->equipos?->equipoDos?->nombre ?? 'Equipo 2';
                                            $oldChecked = collect(old('partido_ids', []))->contains($partido->id);
                                        @endphp
                                        <label class="flex items-center gap-3 rounded-lg border border-complementary-dark/30 bg-light/5 px-3 py-2 cursor-pointer hover:bg-light/10 transition-colors">
                                            <input type="checkbox"
                                                   name="partido_ids[]"
                                                   value="{{ $partido->id }}"
                                                   data-group="{{ $loop->parent->index }}"
                                                   @checked($oldChecked)
                                                   class="js-partido-checkbox w-4 h-4 rounded border-complementary-dark/40 bg-light text-teal-700 focus:ring-teal-700" />
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-semibold text-light truncate">{{ $nombre1 }} vs {{ $nombre2 }}</p>
                                                <p class="text-xs text-complementary-light">{{ $partido->fecha_partido?->format('d/m/Y H:i') ?? 'Sin fecha' }}</p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        {{-- Mensaje cuando aún no hay jornada seleccionada --}}
                        <div id="jornada-empty"
                             class="rounded-xl border border-dashed border-complementary-dark/30 bg-primary/10 p-6 text-center text-sm text-complementary-light">
                            Selecciona una jornada para ver sus partidos.
                        </div>

                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-3 pt-2">
                            <button type="reset"
                                    class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-zinc-200 bg-red-800 hover:bg-red-700 hover:text-light transition-colors">
                                <span class="icon-[material-symbols--close-rounded] w-5 h-5"></span>
                                Limpiar
                            </button>
                            <button type="submit"
                                    class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold bg-secondary text-complementary-primary hover:brightness-110 transition-colors">
                                <span class="icon-[material-symbols--play-circle-outline-rounded] w-5 h-5"></span>
                                Agendar notificación
                            </button>
                        </div>
                    </form>
                @endif
            </section>

            <script>
                (() => {
                    const select = document.getElementById('jornada-select');
                    const empty  = document.getElementById('jornada-empty');
                    const groups = document.querySelectorAll('.js-jornada-group');

                    const showJornada = (value) => {
                        let anyVisible = false;
                        groups.forEach((group) => {
                            const match = value && group.dataset.jornada === value;
                            group.classList.toggle('hidden', !match);
                            if (match) anyVisible = true;
                        });
                        empty?.classList.toggle('hidden', anyVisible);
                    };

                    // Si hay errores de validación, mostrar la jornada del primer partido marcado.
                    const firstChecked = document.querySelector('.js-partido-checkbox:checked');
                    if (firstChecked) {
                        const group = firstChecked.closest('.js-jornada-group');
                        if (group && select) {
                            select.value = group.dataset.jornada;
                        }
                    }

                    select?.addEventListener('change', (e) => showJornada(e.target.value));
                    showJornada(select?.value || '');

                    // Reset: vuelve al placeholder y oculta todo.
                    document.querySelector('form')?.addEventListener('reset', () => {
                        setTimeout(() => {
                            if (select) select.value = '';
                            showJornada('');
                        }, 0);
                    });

                    document.querySelectorAll('.js-select-group').forEach((btn) => {
                        btn.addEventListener('click', () => {
                            const group = btn.dataset.group;
                            const boxes = document.querySelectorAll(`.js-partido-checkbox[data-group="${group}"]`);
                            const allChecked = Array.from(boxes).every((b) => b.checked);
                            boxes.forEach((b) => { b.checked = !allChecked; });
                            btn.textContent = allChecked ? 'Seleccionar todos' : 'Quitar selección';
                        });
                    });
                })();
            </script>
        @endcan
    </div>
</x-admin-layout>
