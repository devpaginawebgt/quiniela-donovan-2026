<x-embed-layout>
    @php
        $equipos = \App\Models\Equipo::select('id', 'nombre', 'imagen', 'codigo_iso')->take(16)->get();

        // Armar 8 enfrentamientos de octavos con los 16 equipos
        $octavos = [];
        for ($i = 0; $i < 16; $i += 2) {
            $octavos[] = [
                'local' => $equipos[$i],
                'visitante' => $equipos[$i + 1],
                'goles_local' => rand(0, 4),
                'goles_visitante' => rand(0, 4),
            ];
        }

        // Asegurar que no haya empates — el local gana en empate
        foreach ($octavos as &$partido) {
            if ($partido['goles_local'] === $partido['goles_visitante']) {
                $partido['goles_local']++;
            }
        }
        unset($partido);

        // Generar cuartos desde ganadores de octavos
        $cuartos = [];
        for ($i = 0; $i < 8; $i += 2) {
            $ganador1 = $octavos[$i]['goles_local'] > $octavos[$i]['goles_visitante']
                ? $octavos[$i]['local'] : $octavos[$i]['visitante'];
            $ganador2 = $octavos[$i + 1]['goles_local'] > $octavos[$i + 1]['goles_visitante']
                ? $octavos[$i + 1]['local'] : $octavos[$i + 1]['visitante'];

            $gl = rand(0, 3);
            $gv = rand(0, 3);
            if ($gl === $gv) $gl++;

            $cuartos[] = [
                'local' => $ganador1,
                'visitante' => $ganador2,
                'goles_local' => $gl,
                'goles_visitante' => $gv,
            ];
        }

        // Semis
        $semis = [];
        for ($i = 0; $i < 4; $i += 2) {
            $ganador1 = $cuartos[$i]['goles_local'] > $cuartos[$i]['goles_visitante']
                ? $cuartos[$i]['local'] : $cuartos[$i]['visitante'];
            $ganador2 = $cuartos[$i + 1]['goles_local'] > $cuartos[$i + 1]['goles_visitante']
                ? $cuartos[$i + 1]['local'] : $cuartos[$i + 1]['visitante'];

            $gl = rand(0, 3);
            $gv = rand(0, 3);
            if ($gl === $gv) $gl++;

            $semis[] = [
                'local' => $ganador1,
                'visitante' => $ganador2,
                'goles_local' => $gl,
                'goles_visitante' => $gv,
            ];
        }

        // Final
        $finalista1 = $semis[0]['goles_local'] > $semis[0]['goles_visitante']
            ? $semis[0]['local'] : $semis[0]['visitante'];
        $finalista2 = $semis[1]['goles_local'] > $semis[1]['goles_visitante']
            ? $semis[1]['local'] : $semis[1]['visitante'];

        $gl = rand(0, 3);
        $gv = rand(0, 3);
        if ($gl === $gv) $gl++;

        $final = [[
            'local' => $finalista1,
            'visitante' => $finalista2,
            'goles_local' => $gl,
            'goles_visitante' => $gv,
        ]];

        $rondas = [
            ['nombre' => 'Octavos', 'partidos' => $octavos],
            ['nombre' => 'Cuartos', 'partidos' => $cuartos],
            ['nombre' => 'Semis', 'partidos' => $semis],
            ['nombre' => 'Final', 'partidos' => $final],
        ];
    @endphp

    <div class="min-h-screen p-4 overflow-x-auto">
        <div class="flex items-start gap-6" style="min-width: max-content;">
            @foreach ($rondas as $rondaIndex => $ronda)
                <div class="flex flex-col items-center gap-2">
                    {{-- Título de la ronda --}}
                    <h2 class="text-sm font-bold uppercase tracking-wider text-complementary-light mb-2">
                        {{ $ronda['nombre'] }}
                    </h2>

                    {{-- Partidos --}}
                    <div class="flex flex-col justify-around h-full"
                         style="gap: {{ ($rondaIndex === 0) ? '0.75rem' : (pow(2, $rondaIndex) * 0.75) . 'rem' }};">
                        @foreach ($ronda['partidos'] as $partido)
                            @php
                                $localGana = $partido['goles_local'] > $partido['goles_visitante'];
                            @endphp
                            <div class="bg-complementary-primary border border-secondary rounded-3xl overflow-hidden w-52 shadow-lg">
                                {{-- Local --}}
                                <div class="flex items-center gap-2 px-4 py-2.5">
                                    <img src="{{ asset($partido['local']->imagen) }}"
                                         alt="{{ $partido['local']->codigo_iso }}"
                                         class="w-7 h-5 object-cover rounded-sm shadow-sm">
                                    <span class="flex-1 text-sm truncate {{ $localGana ? 'text-light font-semibold' : 'text-complementary-light' }}">
                                        {{ $partido['local']->nombre }}
                                    </span>
                                    <span class="text-sm font-bold {{ $localGana ? 'text-secondary' : 'text-complementary-light' }}">
                                        {{ $partido['goles_local'] }}
                                    </span>
                                </div>
                                {{-- Separador --}}
                                <hr class="border-complementary-light/30">
                                {{-- Visitante --}}
                                <div class="flex items-center gap-2 px-4 py-2.5">
                                    <img src="{{ asset($partido['visitante']->imagen) }}"
                                         alt="{{ $partido['visitante']->codigo_iso }}"
                                         class="w-7 h-5 object-cover rounded-sm shadow-sm">
                                    <span class="flex-1 text-sm truncate {{ !$localGana ? 'text-light font-semibold' : 'text-complementary-light' }}">
                                        {{ $partido['visitante']->nombre }}
                                    </span>
                                    <span class="text-sm font-bold {{ !$localGana ? 'text-secondary' : 'text-complementary-light' }}">
                                        {{ $partido['goles_visitante'] }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Líneas conectoras (excepto después de la final) --}}
                @if ($rondaIndex < count($rondas) - 1)
                    <div class="flex flex-col justify-around h-full py-8"
                         style="gap: {{ pow(2, $rondaIndex + 1) * 0.75 }}rem;">
                        @for ($i = 0; $i < count($ronda['partidos']); $i += 2)
                            <div class="flex items-center">
                                <div class="flex flex-col">
                                    <div class="w-6 border-t-2 border-r-2 border-complementary-dark/50 rounded-tr"
                                         style="height: {{ pow(2, $rondaIndex) * 1.5 + 1 }}rem;"></div>
                                    <div class="w-6 border-b-2 border-r-2 border-complementary-dark/50 rounded-br"
                                         style="height: {{ pow(2, $rondaIndex) * 1.5 + 1 }}rem;"></div>
                                </div>
                                <div class="w-6 border-t-2 border-complementary-dark/50"></div>
                            </div>
                        @endfor
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</x-embed-layout>
