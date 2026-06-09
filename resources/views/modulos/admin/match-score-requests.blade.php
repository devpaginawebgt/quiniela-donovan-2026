<x-admin-layout>
    <div class="w-full">
        @can('manage match polling')
            <section class="py-4 sm:py-6 mb-6">

                <div class="flex flex-col gap-4 mb-4 lg:flex-row lg:items-center lg:justify-between">

                    <div class="flex items-center gap-3">
                        <span class="icon-[material-symbols--scoreboard-outline-rounded] w-6 h-6 lg:w-12 lg:h-12 text-dark"></span>
                        <h2 class="font-semibold text-gray-900 text-lg lg:text-4xl">
                            Notificación de marcadores
                        </h2>
                    </div>

                    <a href="{{ route('web.admin.match-score-requests.create') }}"
                       class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold bg-secondary text-complementary-primary hover:brightness-110 transition-colors">
                        <span class="icon-[material-symbols--add-rounded] w-5 h-5"></span>
                        Agendar notificación
                    </a>
                </div>

                @if (session('status'))
                    <div class="js-flash-alert mb-4 flex items-center gap-3 rounded-lg border border-green-400 bg-green-50 px-4 py-3 text-sm text-green-700 transition-opacity duration-500" role="status">
                        <span class="icon-[material-symbols--check-circle-outline-rounded] w-5 h-5"></span>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="js-flash-alert mb-4 flex items-center gap-3 rounded-lg border border-amber-400 bg-amber-50 px-4 py-3 text-sm text-amber-700 transition-opacity duration-500" role="alert">
                        <span class="icon-[material-symbols--warning-outline-rounded] w-5 h-5"></span>
                        <span>{{ session('warning') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="js-flash-alert mb-4 flex items-start gap-3 rounded-lg border border-red-400 bg-red-50 px-4 py-3 text-sm text-red-700 transition-opacity duration-500" role="alert">
                        <span class="icon-[material-symbols--error-outline-rounded] w-5 h-5 shrink-0 mt-0.5"></span>
                        <span class="wrap-break-word">{{ session('error') }}</span>
                    </div>
                @endif

                @if ($requests->isEmpty())
                    <div class="rounded-lg border border-gray-200 bg-white p-6 text-center text-sm text-gray-500">
                        No hay partidos agendados para notificar marcador.
                    </div>
                @else
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-left text-gray-700 bg-white">
                            <thead class="text-xs uppercase bg-gray-100 text-gray-700">
                                <tr>
                                    <th scope="col" class="px-4 py-3 border border-gray-200 text-center">#</th>
                                    <th scope="col" class="px-4 py-3 border border-gray-200">Partido</th>
                                    <th scope="col" class="px-4 py-3 border border-gray-200">Jornada</th>
                                    <th scope="col" class="px-4 py-3 border border-gray-200 text-center">Estado</th>
                                    <th scope="col" class="px-4 py-3 border border-gray-200 text-center">Marcador</th>
                                    <th scope="col" class="px-4 py-3 border border-gray-200 whitespace-nowrap">Fecha de partido</th>
                                    <th scope="col" class="px-4 py-3 border border-gray-200 whitespace-nowrap">Fecha de agenda</th>
                                    <th scope="col" class="px-4 py-3 border border-gray-200 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($requests as $row)
                                    @php
                                        $equipos = $row->partido?->equipos;
                                        $nombre1 = $equipos?->equipoUno?->nombre ?? 'Equipo 1';
                                        $nombre2 = $equipos?->equipoDos?->nombre ?? 'Equipo 2';
                                        $isActive = in_array($row->status, \App\Models\MatchScoreRequest::ACTIVE_STATUSES, true);
                                        $statusBadge = match ($row->status) {
                                            'pending'   => ['bg' => 'bg-gray-100',    'text' => 'text-gray-700',    'label' => 'Pendiente'],
                                            'fetching'  => ['bg' => 'bg-blue-100',    'text' => 'text-blue-700',    'label' => 'Notificando'],
                                            'polling'   => ['bg' => 'bg-blue-100',    'text' => 'text-blue-700',    'label' => 'Notificando'],
                                            'completed' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'label' => 'Finalizado'],
                                            'failed'    => ['bg' => 'bg-red-100',     'text' => 'text-red-700',     'label' => 'Falló'],
                                            'canceled'  => ['bg' => 'bg-zinc-100',    'text' => 'text-zinc-600',    'label' => 'Cancelado'],
                                            default     => ['bg' => 'bg-zinc-100',    'text' => 'text-zinc-600',    'label' => ucfirst($row->status)],
                                        };
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3 border border-gray-200 text-center tabular-nums text-gray-500">{{ $row->id }}</td>
                                        <td class="px-4 py-3 border border-gray-200 font-medium text-gray-900">{{ $nombre1 }} <b>vs</b> {{ $nombre2 }}</td>
                                        <td class="px-4 py-3 border border-gray-200 whitespace-nowrap">{{ $row->partido?->jornada?->name ?? '—' }}</td>
                                        <td class="px-4 py-3 border border-gray-200 text-center">
                                            <span class="inline-flex items-center gap-1 text-sm font-medium px-2.5 py-0.5 rounded-full {{ $statusBadge['bg'] }} {{ $statusBadge['text'] }}">
                                                {{ $statusBadge['label'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 border border-gray-200 text-center tabular-nums font-semibold text-gray-900">{{ $row->last_goals_home }} - {{ $row->last_goals_away }}</td>
                                        <td class="px-4 py-3 border border-gray-200 whitespace-nowrap">{{ $row->partido->fecha_partido?->timezone('America/Guatemala')->format('d/m/Y h:i A') ?? '—' }}</td>
                                        <td class="px-4 py-3 border border-gray-200 whitespace-nowrap">{{ $row->created_at?->timezone('America/Guatemala')->format('d/m/Y h:i A') ?? '—' }}</td>
                                        <td class="px-4 py-3 border border-gray-200 text-right">
                                            @if ($isActive)
                                                <form action="{{ route('web.admin.match-score-requests.destroy', $row) }}" method="POST" class="inline" onsubmit="return confirm('¿Cancelar la notificación de marcadores para este partido?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium bg-red-600 text-white hover:bg-red-700 transition-colors">
                                                        <span class="icon-[material-symbols--delete] w-4 h-4"></span>
                                                        Cancelar
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-xs text-gray-400">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>

            <script>
                (() => {
                    document.querySelectorAll('.js-flash-alert').forEach((alert) => {
                        setTimeout(() => {
                            alert.classList.add('opacity-0');
                            setTimeout(() => alert.remove(), 500);
                        }, 3000);
                    });
                })();
            </script>
        @endcan
    </div>
</x-admin-layout>
