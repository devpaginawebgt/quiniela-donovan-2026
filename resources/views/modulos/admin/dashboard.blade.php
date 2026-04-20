<x-admin-layout>
    <div class="max-w-screen-2xl mx-auto">

        {{-- Módulo: Reporte --}}
        @can('admin.ver-reportes')
        <section class="rounded-2xl bg-complementary-primary/80 backdrop-blur shadow-lg py-4 sm:py-6 mb-6">

            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <span class="icon-[material-symbols--supervised-user-circle] w-6 h-6 lg:w-8 lg:h-8 text-secondary"></span>
                    <h2 class="font-semibold text-light text-lg lg:text-2xl">Reporte de Usuarios</h2>
                </div>

                {{-- Buscador (Flowbite) --}}
                <div class="relative w-full max-w-xs hidden sm:block">
                    <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                        <span class="icon-[material-symbols--search] w-4 h-4 text-complementary-light"></span>
                    </div>
                    <input
                        type="search"
                        id="table-search-reporte"
                        class="block w-full p-2 ps-10 text-sm rounded-lg bg-primary/40 border border-complementary-dark/30 text-light placeholder-complementary-light focus:ring-secondary focus:border-secondary"
                        placeholder="Buscar participante..." />
                </div>
            </div>

            {{-- Tabla Flowbite --}}
            <div class="relative overflow-x-auto rounded-lg border border-complementary-dark/20">
                <table class="w-full text-sm text-left rtl:text-right text-complementary-light">
                    <thead class="text-xs uppercase bg-primary/70 text-light">
                        <tr>
                            <th scope="col" class="px-4 py-3">#</th>
                            <th scope="col" class="px-4 py-3">Participante</th>
                            <th scope="col" class="px-4 py-3">País</th>
                            <th scope="col" class="px-4 py-3">Tipo</th>
                            <th scope="col" class="px-4 py-3 text-right">Puntos</th>
                            <th scope="col" class="px-4 py-3 text-center">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Filas de ejemplo; sustituir por @foreach($participantes as $p) cuando conectes el controlador --}}
                        @php
                            $ejemplos = [
                                ['id' => 1, 'nombre' => 'Ana López',     'pais' => 'Guatemala', 'tipo' => 'Doctor',      'puntos' => 128, 'activo' => true],
                                ['id' => 2, 'nombre' => 'Carlos Pérez',  'pais' => 'Honduras',  'tipo' => 'Dependiente', 'puntos' => 115, 'activo' => true],
                                ['id' => 3, 'nombre' => 'María Rodríguez','pais' => 'Guatemala','tipo' => 'Dependiente', 'puntos' => 97,  'activo' => false],
                                ['id' => 4, 'nombre' => 'Juan Castillo', 'pais' => 'Honduras',  'tipo' => 'Doctor',      'puntos' => 82,  'activo' => true],
                            ];
                        @endphp

                        @foreach($ejemplos as $row)
                            <tr class="border-t border-complementary-dark/20 hover:bg-primary/30 transition-colors">
                                <td class="px-4 py-3 font-medium text-light">{{ $row['id'] }}</td>
                                <td class="px-4 py-3 font-medium text-light whitespace-nowrap">{{ $row['nombre'] }}</td>
                                <td class="px-4 py-3">{{ $row['pais'] }}</td>
                                <td class="px-4 py-3">{{ $row['tipo'] }}</td>
                                <td class="px-4 py-3 text-right tabular-nums font-semibold text-secondary">{{ $row['puntos'] }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($row['activo'])
                                        <span class="inline-flex items-center gap-1 bg-secondary/20 text-secondary text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                            Activo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-complementary-dark/40 text-complementary-light text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-complementary-light"></span>
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Footer de tabla --}}
            <div class="flex items-center justify-between mt-4 text-xs text-complementary-light">
                <span>Mostrando <span class="font-semibold text-light">4</span> de <span class="font-semibold text-light">4</span> registros</span>
            </div>
        </section>
        @endcan

    </div>
</x-admin-layout>
