<x-admin-layout>
    <div class="w-full">
        @can('create admin notifications')
        <section class="py-4 sm:py-6 mb-6">

            <div class="flex flex-col gap-4 mb-4 lg:flex-row lg:items-center lg:justify-between">

                <div class="flex items-center gap-3">
                    <span class="icon-[material-symbols--notifications-active-outline-rounded] w-6 h-6 lg:w-12 lg:h-12 text-dark"></span>
                    <h2 class="font-semibold text-gray-900 text-lg lg:text-4xl">
                        Notificaciones
                    </h2>
                </div>

                <a href="{{ route('web.admin.notifications.create') }}"
                    class="inline-flex items-center justify-center gap-2 bg-primary hover:brightness-110 text-light text-sm px-4 py-2 rounded-lg transition self-start lg:self-auto">
                    <span class="icon-[material-symbols--send-rounded] w-4 h-4"></span>
                    <span>Enviar Notificación</span>
                </a>

            </div>

            {{-- Tabla --}}

            <table id="tabla-notificaciones"
                data-url="{{ route('web.admin.notifications.data') }}"
                data-show-url="{{ url('admin/notificaciones') }}"
                data-cancel-url-template="{{ url('admin/notificaciones') }}/__ID__/cancelar">

                <thead class="text-xs uppercase bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 border border-gray-200">#</th>
                        <th class="px-4 py-3 border border-gray-200">Título</th>
                        <th class="px-4 py-3 border border-gray-200">Audiencia</th>
                        <th class="px-4 py-3 border border-gray-200">Programada para</th>
                        <th class="px-4 py-3 border border-gray-200">Fecha de creación</th>
                        <th class="px-4 py-3 border border-gray-200">Estado</th>
                        <th class="px-4 py-3 border border-gray-200">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200"></tbody>
            </table>
        </section>

        {{-- Modal detalle --}}

        <div id="notification-detail-modal"
            tabindex="-1"
            aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">

            <div class="relative p-4 w-full max-w-2xl max-h-full">

                <div class="relative bg-white rounded-lg shadow-lg">

                    {{-- Header --}}
                    <div class="flex items-center justify-between p-4 border-b border-gray-200 rounded-t">
                        <div class="flex items-center gap-2">
                            <span class="icon-[material-symbols--notifications-active-outline-rounded] w-5 h-5 text-primary"></span>
                            <h3 class="text-base font-semibold text-gray-900">Detalle de la notificación</h3>
                        </div>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg w-8 h-8 inline-flex justify-center items-center"
                            data-modal-hide="notification-detail-modal">
                            <span class="icon-[material-symbols--close-rounded] w-5 h-5"></span>
                            <span class="sr-only">Cerrar</span>
                        </button>
                    </div>

                    {{-- Body --}}
                    <div class="p-4 space-y-4 text-sm text-gray-700">

                        <div class="flex items-start gap-3">
                            <img data-field="image"
                                src=""
                                alt=""
                                class="hidden w-16 h-16 rounded-lg object-contain border border-gray-200 bg-gray-50 p-1" />
                            <div class="flex-1 min-w-0">
                                <p class="text-xs uppercase tracking-wider text-gray-500">Título</p>
                                <p data-field="title" class="font-semibold text-gray-900 wrap-break-word">—</p>
                            </div>
                            <span data-field="status_badge" class="shrink-0"></span>
                        </div>

                        <div class="my-8">
                            <p class="text-xs uppercase tracking-wider text-gray-500 mb-1">Mensaje</p>
                            <p data-field="description" class="whitespace-pre-line wrap-break-word">—</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs uppercase tracking-wider text-gray-500">Audiencia</p>
                                <p data-field="audience">—</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wider text-gray-500">Creada por</p>
                                <p data-field="created_by">—</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wider text-gray-500">Programada para</p>
                                <p data-field="scheduled_at">—</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wider text-gray-500">Enviada</p>
                                <p data-field="sent_at">—</p>
                            </div>
                        </div>

                        <div data-field="comment-wrapper" class="hidden">
                            <p class="text-xs uppercase tracking-wider text-gray-500 mb-1">Comentario</p>
                            <p data-field="comment" class="text-gray-600 italic wrap-break-word">—</p>
                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="flex items-center justify-end p-4 border-t border-gray-200 rounded-b">
                        <button type="button"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg"
                            data-modal-hide="notification-detail-modal">
                            Cerrar
                        </button>
                    </div>

                </div>
            </div>
        </div>
        @endcan
    </div>
</x-admin-layout>
