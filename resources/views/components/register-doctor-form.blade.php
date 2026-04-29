<form
    method="POST"
    action="{{ route('register') }}"
    class="formulario-auth grid grid-cols-1 md:grid-cols-2 gap-6 w-full max-w-2xl mx-auto"
>
    @csrf

    <input type="hidden" name="user_type_id" value="2">
    <input type="hidden" name="accepted_terms_version" value="">

    <x-auth-input
        label="Nombres del Doctor"
        id="doc_nombres"
        name="nombres"
        placeholder="Ingrese sus nombres"
        minlength="2"
        maxlength="60"
        :required="true"
    >
        <x-slot name="prefix">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
        </x-slot>
    </x-auth-input>

    <x-auth-input
        label="Apellidos del Doctor"
        id="doc_apellidos"
        name="apellidos"
        placeholder="Ingrese sus apellidos"
        minlength="2"
        maxlength="60"
        :required="true"
    >
        <x-slot name="prefix">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
        </x-slot>
    </x-auth-input>

    <x-auth-input
        label="DPI del Doctor"
        id="doc_numero_documento"
        name="numero_documento"
        placeholder="Ingrese su DPI"
        minlength="6"
        maxlength="20"
        :required="true"
    >
        <x-slot name="prefix">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
            </svg>
        </x-slot>
    </x-auth-input>

    <x-auth-input
        label="Teléfono del Doctor"
        id="doc_telefono"
        name="telefono"
        placeholder="Ingrese su teléfono"
        maxlength="8"
        pattern="[0-9]{8}"
        title="Solo se permiten 8 dígitos numéricos"
        :required="true"
    >
        <x-slot name="prefix">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
            </svg>
        </x-slot>
    </x-auth-input>

    <x-auth-input
        label="Correo electrónico del Doctor"
        id="doc_email"
        name="email"
        type="email"
        placeholder="correo@ejemplo.com"
        minlength="5"
        maxlength="255"
        :required="true"
    >
        <x-slot name="prefix">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
            </svg>
        </x-slot>
    </x-auth-input>

    <x-auth-select label="País" id="doc_pais_id" name="pais_id" :required="true">
        <x-slot name="prefix">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
            </svg>
        </x-slot>
        <option value="{{ $country->id }}" {{ old('pais_id') === $country->id ? 'selected' : '' }}>
            {{ $country->name }}
        </option>
    </x-auth-select>

    <div class="md:col-span-2">
        <x-auth-input
            label="Dirección del Doctor"
            id="doc_direccion"
            name="direccion"
            placeholder="Ingrese su dirección"
            minlength="5"
            maxlength="255"
            :required="true"
        >
            <x-slot name="prefix">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
            </x-slot>
        </x-auth-input>
    </div>

    <x-auth-input
        label="Región del Doctor"
        id="doc_region"
        name="region"
        placeholder="Ingrese su región"
        minlength="2"
        maxlength="100"
        :required="true"
    >
        <x-slot name="prefix">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m0-15v6m0-6L3.75 3m5.25 3L3.75 9m5.25-3h10.5m0 0V15m0-12L21 3m-1.5 3L21 9" />
            </svg>
        </x-slot>
    </x-auth-input>

    <x-auth-select label="Visitador del Doctor" id="doc_visitor" name="visitor_id">
        <x-slot name="prefix">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
            </svg>
        </x-slot>
        <option value="">Sin seleccionar</option>
        @foreach ($visitors as $visitor)
            <option value="{{ $visitor->id }}" {{ old('visitor_id') == $visitor->id ? 'selected' : '' }}>
                {{ $visitor->name }} {{ $visitor->lastname }}
            </option>
        @endforeach
    </x-auth-select>

    <x-auth-input
        label="Número de colegiado"
        id="doc_numero_colegiado"
        name="colegiado"
        placeholder="Ingrese su colegiado"
        minlength="2"
        maxlength="20"
        :required="true"
    >
        <x-slot name="prefix">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
            </svg>
        </x-slot>
    </x-auth-input>

    {{-- Submit --}}
    <div class="mt-2 md:col-span-2">
        <button
            type="button"
            class="btn-crear-cuenta w-full bg-red-600/80 text-light font-bold rounded-full text-lg px-6 py-3.5 hover:brightness-[1.1] focus:ring-3 focus:ring-white flex items-center justify-center gap-2"
        >
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
            </svg>
            Crear Cuenta
        </button>
    </div>
</form>
