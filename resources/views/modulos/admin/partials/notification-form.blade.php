@php
    /** @var \App\Models\PushNotification|null $notification */
    $notification ??= null;
    $isEdit = (bool) $notification;

    $formAction = $isEdit
        ? route('web.admin.notifications.update', $notification)
        : route('web.admin.notifications.store');

    $headerTitle = $isEdit ? 'Editar notificación' : 'Enviar notificación';

    $userTimezone = auth()->user()?->country?->timezone ?? config('app.timezone');
    $scheduledLocal = $notification?->scheduled_at?->copy()->timezone($userTimezone);

    $defaultScheduleDate = $scheduledLocal?->toDateString() ?? now()->addDay()->toDateString();
    $defaultScheduleTime = $scheduledLocal?->format('H:i') ?? '08:00';

    // Para crear: el toggle viene encendido por defecto.
    // Para editar: si la notificación tiene scheduled_at, el toggle arranca encendido.
    $scheduleEnabledFallback = $isEdit
        ? ($scheduledLocal ? '1' : '0')
        : '1';
    $scheduleEnabledOld = old('schedule_enabled', $scheduleEnabledFallback) === '1';

    $currentImageUrl = $isEdit && $notification->image_path
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($notification->image_path)
        : null;
@endphp

<section class="rounded-2xl bg-complementary-primary backdrop-blur shadow-lg py-4 sm:py-6 px-4 sm:px-6 mb-6">

    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <span class="icon-[material-symbols--notifications-active-outline-rounded] w-6 h-6 lg:w-8 lg:h-8 text-secondary"></span>
            <h2 class="font-semibold text-light text-lg lg:text-2xl">{{ $headerTitle }}</h2>
        </div>
        <a href="{{ route('web.admin.notifications.index') }}"
            class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-teal-700 text-light hover:brightness-110 transition-colors">
            <span class="icon-[material-symbols--arrow-back-rounded] w-5 h-5"></span>
            <span class="hidden sm:inline">Volver al listado</span>
        </a>
    </div>

    @if (session('status'))
        <div class="js-flash-alert mb-4 flex items-center gap-3 rounded-lg border border-green-400 bg-green-700/30 px-4 py-3 text-sm text-green-400 transition-opacity duration-500"
            role="status">
            <span class="icon-[material-symbols--check-circle-outline-rounded] w-5 h-5"></span>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    @if (session('warning'))
        <div class="js-flash-alert mb-4 flex items-center gap-3 rounded-lg border border-amber-400 bg-amber-700/30 px-4 py-3 text-sm text-amber-300 transition-opacity duration-500"
            role="alert">
            <span class="icon-[material-symbols--warning-outline-rounded] w-5 h-5"></span>
            <span>{{ session('warning') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="js-flash-alert mb-4 flex items-start gap-3 rounded-lg border border-red-400 bg-red-700/30 px-4 py-3 text-sm text-red-300 transition-opacity duration-500"
            role="alert">
            <span class="icon-[material-symbols--error-outline-rounded] w-5 h-5 shrink-0 mt-0.5"></span>
            <span class="wrap-break-word">{{ session('error') }}</span>
        </div>
    @endif

    <x-toast-errors :errors="$errors" />

    <div class="2xl:w-6xl grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-6">

        {{-- Formulario --}}
        <div class="min-w-0">
            <form
                action="{{ $formAction }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-5"
            >
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                {{-- Audiencia --}}
                <div>
                    <label for="user_type_id" class="block mb-2 text-sm font-medium text-light">Audiencia</label>
                    <select id="user_type_id"
                            name="user_type_id"
                            class="block w-full py-2.5 px-3 text-sm rounded-lg bg-light text-dark border border-complementary-dark/30 focus:ring-secondary focus:border-secondary">
                        <option value="">Todos los participantes</option>
                        @foreach($userTypes as $userType)
                            <option value="{{ $userType->id }}" @selected(old('user_type_id', $notification?->user_type_id) == $userType->id)>{{ $userType->plural_name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- País --}}
                <div>
                    <label for="country_id" class="block mb-2 text-sm font-medium text-light">País</label>
                    <select id="country_id"
                            name="country_id"
                            class="block w-full py-2.5 px-3 text-sm rounded-lg bg-light text-dark border border-complementary-dark/30 focus:ring-secondary focus:border-secondary">
                        <option value="">Todos los países</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" @selected(old('country_id', $notification?->country_id) == $country->id)>{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Título --}}
                <div>
                    <label for="title" class="block mb-2 text-sm font-medium text-light">Título</label>
                    <input type="text"
                        id="title"
                        name="title"
                        maxlength="100"
                        value="{{ old('title', $notification?->title) }}"
                        placeholder="Ej. ¡Nueva jornada disponible!"
                        class="block w-full py-2.5 px-3 text-sm rounded-lg border bg-light text-dark border-complementary-dark/30 placeholder-zinc-400 focus:ring-secondary focus:border-secondary"
                        required />
                    <p class="mt-1 text-xs text-complementary-light">Máximo 100 caracteres.</p>
                </div>

                {{-- Mensaje --}}
                <div>
                    <label for="description" class="block mb-2 text-sm font-medium text-light">Mensaje</label>
                    <textarea id="description"
                            name="description"
                            rows="4"
                            maxlength="240"
                            placeholder="Escribe el contenido de la notificación..."
                            class="block w-full p-2.5 text-sm rounded-lg bg-light text-dark border-complementary-dark/30 placeholder-zinc-400 focus:ring-secondary focus:border-secondary"
                            required>{{ old('description', $notification?->description) }}</textarea>
                    <p class="mt-1 text-xs text-complementary-light">Máximo 240 caracteres.</p>
                </div>

                {{-- Imagen --}}
                <div>
                    <label for="image" class="block mb-2 text-sm font-medium text-light">Imagen <span class="text-complementary-light font-normal">(opcional)</span></label>

                    @if ($currentImageUrl)
                        <div class="mb-3 flex items-center gap-3 p-3 rounded-lg bg-complementary-primary/40 border border-complementary-dark/30">
                            <img src="{{ $currentImageUrl }}" alt="Imagen actual" class="w-14 h-14 rounded-md object-contain bg-light p-1" />
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-complementary-light mb-1">Imagen actual</p>
                                <label class="inline-flex items-center gap-2 text-xs text-light cursor-pointer">
                                    <input type="hidden" name="remove_image" value="0">
                                    <input type="checkbox"
                                           id="remove_image"
                                           name="remove_image"
                                           value="1"
                                           @checked(old('remove_image') === '1')
                                           class="w-4 h-4 rounded text-secondary bg-light border-complementary-dark/30 focus:ring-secondary">
                                    <span>Eliminar imagen actual</span>
                                </label>
                            </div>
                        </div>
                    @endif

                    <input type="file"
                        id="image"
                        name="image"
                        accept="image/*"
                        data-max-size="512000"
                        class="block w-full text-sm text-complementary-dark rounded-lg cursor-pointer bg-light border focus:outline-none focus:ring-secondary focus:border-secondary file:mr-3 file:py-2.5 file:border-0 file:text-sm file:font-semibold file:bg-secondary file:text-complementary-primary hover:file:brightness-110" />
                    <p id="image-help" class="mt-1 text-xs text-complementary-light">{{ $currentImageUrl ? 'Sube una nueva imagen para reemplazar la actual. Tamaño máximo 500 KB.' : 'Solo imágenes. Tamaño máximo 500 KB.' }}</p>
                </div>

                {{-- Programar envío --}}
                <div>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="hidden" name="schedule_enabled" value="0">
                        <input type="checkbox"
                               id="schedule_toggle"
                               name="schedule_enabled"
                               value="1"
                               @checked($scheduleEnabledOld)
                               class="sr-only peer">
                        <div class="relative w-11 h-6 bg-complementary-dark/40 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-secondary rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:inset-s-0.5 after:bg-white after:border-complementary-dark/30 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary"></div>
                        <span class="ms-3 text-sm font-medium text-light">Programar envío</span>
                    </label>

                    <div id="schedule_fields" class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-5 {{ $scheduleEnabledOld ? '' : 'hidden' }}">
                        <div>
                            <label for="send_at_date" class="block mb-2 text-sm font-medium text-light">Fecha de envío</label>
                            <input type="date"
                                   id="send_at_date"
                                   name="send_at_date"
                                   min="{{ now()->toDateString() }}"
                                   value="{{ old('send_at_date', $defaultScheduleDate) }}"
                                   data-default="{{ $defaultScheduleDate }}"
                                   class="block w-full py-2.5 px-3 text-sm rounded-lg bg-light text-dark border border-complementary-dark/30 focus:ring-secondary focus:border-secondary" />
                        </div>
                        <div>
                            <label for="send_at_time" class="block mb-2 text-sm font-medium text-light">Hora de envío</label>
                            <input type="time"
                                   id="send_at_time"
                                   name="send_at_time"
                                   step="60"
                                   value="{{ old('send_at_time', $defaultScheduleTime) }}"
                                   data-default="{{ $defaultScheduleTime }}"
                                   class="block w-full py-2.5 px-3 text-sm rounded-lg bg-light text-dark border border-complementary-dark/30 focus:ring-secondary focus:border-secondary" />
                        </div>
                        <p class="sm:col-span-2 -mt-2 text-xs text-complementary-light">Se enviará a partir de la fecha y hora indicadas (mínimo 5 minutos en el futuro).</p>
                    </div>
                </div>

                {{-- Acciones --}}
                @php
                    $submitLabels = [
                        'create_schedule'   => 'Programar notificación',
                        'create_immediate'  => 'Enviar notificación',
                        'edit_schedule'     => 'Actualizar programación',
                        'edit_immediate'    => 'Actualizar y enviar ahora',
                    ];
                    $submitKey = ($isEdit ? 'edit_' : 'create_') . ($scheduleEnabledOld ? 'schedule' : 'immediate');
                    $submitInitialLabel = $submitLabels[$submitKey];
                @endphp
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 pt-2">
                    <button type="reset"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-zinc-200  bg-red-800 hover:bg-red-700 hover:text-light transition-colors">
                        <span class="icon-[material-symbols--close-rounded] w-5 h-5"></span>
                        Limpiar
                    </button>
                    <button type="submit"
                            id="submit_button"
                            data-mode="{{ $isEdit ? 'edit' : 'create' }}"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold bg-secondary text-complementary-primary hover:brightness-110 transition-colors disabled:opacity-60 disabled:cursor-not-allowed disabled:hover:brightness-100">
                        <span id="submit_icon" class="{{ $scheduleEnabledOld ? 'icon-[material-symbols--schedule-send-outline-rounded]' : 'icon-[material-symbols--send-rounded]' }} w-5 h-5"></span>
                        <span id="submit_label">{{ $submitInitialLabel }}</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Vista previa --}}
        <aside class="min-w-0">
            <p class="text-xs uppercase tracking-wider text-complementary-light mb-2">Vista previa</p>
            <div class="rounded-xl border border-zinc-100 bg-zinc-600 backdrop-blur-xl p-4">
                <div class="flex items-start gap-3">
                    <img src="{{ asset('images/logos/logo-liga.png') }}"
                        alt="{{ config('app.name', 'Quiniela') }}"
                        class="shrink-0 w-10 h-10 rounded-lg object-contain bg-complementary-primary p-1" />
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-sm font-semibold text-light truncate">{{ config('app.name', 'Quiniela') }}</span>
                            <span class="text-[10px] text-complementary-light whitespace-nowrap">ahora</span>
                        </div>
                        <p id="preview-title" class="text-sm font-medium text-light mt-0.5">{{ old('title', $notification?->title) ?: 'Título de la notificación' }}</p>
                        <p id="preview-body" class="text-xs text-complementary-light mt-1 line-clamp-3">{{ old('description', $notification?->description) ?: 'El contenido de tu mensaje aparecerá aquí mientras lo escribes.' }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-4 rounded-xl border border-zinc-400 bg-primary/20 p-4">
                <p class="text-xs uppercase tracking-wider text-light mb-2">Tips</p>
                <ul class="space-y-2 text-xs text-complementary-light">
                    <li class="flex items-start gap-2">
                        <span class="icon-[material-symbols--check-circle-outline-rounded] w-4 h-4 text-secondary shrink-0 mt-0.5"></span>
                        <span>Sé breve y claro en el título.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="icon-[material-symbols--check-circle-outline-rounded] w-4 h-4 text-secondary shrink-0 mt-0.5"></span>
                        <span>Evita enviar más de 2 notificaciones al día.</span>
                    </li>
                </ul>
            </div>
        </aside>
    </div>
</section>

<script>
    (() => {
        document.querySelectorAll('.js-flash-alert').forEach((alert) => {
            setTimeout(() => {
                alert.classList.add('opacity-0');
                setTimeout(() => alert.remove(), 500);
            }, 3000);
        });

        const titleInput = document.getElementById('title');
        const bodyInput = document.getElementById('description');
        const imageInput = document.getElementById('image');
        const imageHelp = document.getElementById('image-help');
        const previewTitle = document.getElementById('preview-title');
        const previewBody = document.getElementById('preview-body');
        const removeImageCheckbox = document.getElementById('remove_image');

        const defaultTitle = 'Título de la notificación';
        const defaultBody = 'El contenido de tu mensaje aparecerá aquí mientras lo escribes.';
        const defaultHelp = imageHelp?.textContent ?? 'Solo imágenes. Tamaño máximo 500 KB.';

        titleInput?.addEventListener('input', (e) => {
            previewTitle.textContent = e.target.value.trim() || defaultTitle;
        });

        bodyInput?.addEventListener('input', (e) => {
            previewBody.textContent = e.target.value.trim() || defaultBody;
        });

        const scheduleToggle = document.getElementById('schedule_toggle');
        const scheduleFields = document.getElementById('schedule_fields');
        const scheduleDate = document.getElementById('send_at_date');
        const scheduleTime = document.getElementById('send_at_time');
        const submitButton = document.getElementById('submit_button');
        const submitIcon = document.getElementById('submit_icon');
        const submitLabel = document.getElementById('submit_label');

        const sendIconClass = 'icon-[material-symbols--send-rounded]';
        const scheduleIconClass = 'icon-[material-symbols--schedule-send-outline-rounded]';

        const mode = submitButton?.dataset.mode ?? 'create';
        const labels = {
            create: { schedule: 'Programar notificación',    immediate: 'Enviar notificación' },
            edit:   { schedule: 'Actualizar programación',   immediate: 'Actualizar y enviar ahora' },
        };

        const applyScheduleState = (enabled) => {
            scheduleFields.classList.toggle('hidden', !enabled);
            if (enabled) {
                if (!scheduleDate.value) scheduleDate.value = scheduleDate.dataset.default ?? '';
                if (!scheduleTime.value) scheduleTime.value = scheduleTime.dataset.default ?? '';
            } else {
                scheduleDate.value = '';
                scheduleTime.value = '';
            }
            submitIcon?.classList.toggle(sendIconClass, !enabled);
            submitIcon?.classList.toggle(scheduleIconClass, enabled);
            if (submitLabel) {
                submitLabel.textContent = labels[mode][enabled ? 'schedule' : 'immediate'];
            }
        };

        scheduleToggle?.addEventListener('change', (e) => {
            applyScheduleState(e.target.checked);
        });

        // Cuando el usuario sube una nueva imagen, desmarca el "Eliminar imagen actual"
        // para evitar combinaciones contradictorias.
        imageInput?.addEventListener('change', (e) => {
            const file = e.target.files?.[0];

            imageHelp.classList.remove('text-red-400');
            imageHelp.classList.add('text-complementary-light');
            imageHelp.textContent = defaultHelp;

            if (!file) return;

            const maxSize = parseInt(imageInput.dataset.maxSize, 10);

            if (!file.type.startsWith('image/')) {
                imageInput.value = '';
                imageHelp.classList.remove('text-complementary-light');
                imageHelp.classList.add('text-red-400');
                imageHelp.textContent = 'El archivo seleccionado no es una imagen válida.';
                return;
            }

            if (file.size > maxSize) {
                imageInput.value = '';
                imageHelp.classList.remove('text-complementary-light');
                imageHelp.classList.add('text-red-400');
                imageHelp.textContent = 'La imagen supera el tamaño máximo permitido (500 KB).';
                return;
            }

            if (removeImageCheckbox?.checked) {
                removeImageCheckbox.checked = false;
            }

            const sizeKb = (file.size / 1024).toFixed(1);
            imageHelp.textContent = `Imagen seleccionada: ${file.name} (${sizeKb} KB).`;
        });

        const form = submitButton?.closest('form');
        const spinnerIconClass = 'icon-[material-symbols--progress-activity]';
        const submittingLabels = {
            create: { schedule: 'Programando...',   immediate: 'Enviando...' },
            edit:   { schedule: 'Actualizando...',  immediate: 'Enviando...' },
        };

        form?.addEventListener('submit', () => {
            if (submitButton.disabled) return;

            submitButton.disabled = true;

            if (submitIcon) {
                submitIcon.classList.remove(sendIconClass, scheduleIconClass);
                submitIcon.classList.add(spinnerIconClass, 'animate-spin');
            }

            if (submitLabel) {
                const enabled = scheduleToggle?.checked ?? false;
                submitLabel.textContent = submittingLabels[mode][enabled ? 'schedule' : 'immediate'];
            }
        });
    })();
</script>
