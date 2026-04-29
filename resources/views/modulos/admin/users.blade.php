<x-admin-layout>
    <div class="w-full">
        @can('admin.ver-reportes')
        <section class="py-4 sm:py-6 mb-6">

            <div class="flex flex-col gap-4 mb-4 lg:flex-row lg:items-center lg:justify-between">

                <div class="flex items-center gap-3">
                    <span class="icon-[material-symbols--supervised-user-circle] w-6 h-6 lg:w-12 lg:h-12 text-dark"></span>
                    <h2 class="font-semibold text-gray-900 text-lg lg:text-4xl">
                        Reporte de Usuarios Registrados
                    </h2>
                </div>

                <form id="form-export"
                    class="flex justify-end lg:justify-normal"
                    action="{{ route('web.admin.reports.users.export') }}"
                    method="GET">

                    <button
                        id="btn-export"
                        type="submit"
                        class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                        <span id="btn-export-icon" class="icon-[material-symbols--download-rounded] w-4 h-4"></span>
                        <span id="btn-export-text">Descargar Excel</span>
                    </button>

                </form>

            </div>

            {{-- Tabla --}}

            <table id="tabla-usuarios"
                data-url="{{ route('web.admin.reports.users.data') }}">

                <thead class="text-xs uppercase bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 border border-gray-200">#</th>
                        <th class="px-4 py-3 border border-gray-200">Nombre</th>
                        <th class="px-4 py-3 border border-gray-200">No. Documento</th>
                        <th class="px-4 py-3 border border-gray-200">Email</th>
                        <th class="px-4 py-3 border border-gray-200">Teléfono</th>
                        <th class="px-4 py-3 border border-gray-200">Dirección</th>
                        <th class="px-4 py-3 border border-gray-200">Colegiado</th>
                        <th class="px-4 py-3 border border-gray-200">País</th>
                        <th class="px-4 py-3 border border-gray-200">Tipo</th>
                        <th class="px-4 py-3 border border-gray-200">Cadena</th>
                        <th class="px-4 py-3 border border-gray-200">Visitador</th>
                        <th class="px-4 py-3 border border-gray-200">Región</th>
                        <th class="px-4 py-3 border border-gray-200">Farmacia</th>
                        <th class="px-4 py-3 border border-gray-200">Pts. Trivias</th>
                        <th class="px-4 py-3 border border-gray-200">Pts. Predicciones</th>
                        <th class="px-4 py-3 border border-gray-200">Pts. Bonus</th>
                        <th class="px-4 py-3 border border-gray-200">Pts. Total</th>
                        <th class="px-4 py-3 border border-gray-200">Registro</th>
                        <th class="px-4 py-3 border border-gray-200">Estado</th>
                        <th class="px-4 py-3 border border-gray-200">Notificaciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200"></tbody>
            </table>
        </section>
        @endcan
    </div>
</x-admin-layout>