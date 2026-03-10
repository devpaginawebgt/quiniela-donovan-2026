
<x-guest-layout>
    <x-auth-card>
        @php
            // $ip = urlencode($_SERVER['REMOTE_ADDR']);
            // $apiKey = env('GEOLOCATION_API_KEY');
            // $url = "http://api.ipinfo.io/lite/{$ip}?token={$apiKey}";

            // $dataArray = json_decode(file_get_contents($url));
            $paisCliente = 'GT';
        @endphp

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        @if (isset($message_error))
            <div class="bg-red-300 px-4 py-2 text-red-900 rounded-xl text-center" id="message-view">
                <h3 class="text-2xl font-bold">Error al registrarse</h3>
                <p>{{ $message_error }}</p>
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('register.doctor') }}"
            class="grid grid-cols-2 gap-4 formulario-auth mb-1"
        >
            @csrf

            <!-- Name -->
            <div>
                <x-label
                    for="nombres"
                    :value="__('Nombres')"
                />

                <x-input
                    id="nombres"
                    class="block mt-1 w-full"
                    type="text"
                    name="nombres"
                    :value="old('nombres')"
                    required
                />
            </div>

            <!-- Name -->
            <div>
                <x-label
                    for="apellidos"
                    :value="__('Apellidos')"
                />

                <x-input
                    id="apellidos"
                    class="block mt-1 w-full"
                    type="text"
                    name="apellidos"
                    :value="old('apellidos')"
                    required
                />
            </div>

            <!-- Name -->
            <div>
                <x-label
                    for="numero_documento"
                    :value="__('DPI')"
                />

                <x-input
                    id="numero_documento"
                    class="block mt-1 w-full"
                    type="text"
                    name="numero_documento"
                    :maxlength="13"
                    :value="old('numero_documento')"
                    required
                />
            </div>

            <!-- Name -->
            <div>
                <x-label
                    for="telefono"
                    :value="__('Teléfono')"
                />

                <x-input
                    id="telefono"
                    class="block mt-1 w-full"
                    type="text"
                    :maxlength="8"
                    name="telefono"
                    :value="old('telefono')"
                    required
                />
            </div>


            <!-- Email Address -->
            <div>
                <x-label
                    for="email"
                    :value="__('Correo Electrónico')"
                />

                <x-input
                    id="email"
                    class="block mt-1 w-full"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                />
            </div>

            <div>
                <x-label
                    for="pais_id"
                    :value="__('Pais')"
                />

                <select
                    name="pais_id"
                    id="pais_id"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full h-10 px-4"
                    required
                >
                    @php
                        $paises = [
                            1 => 'Guatemala',
                            2 => 'Honduras'
                        ];
                    @endphp

                    @foreach ($paises as $value => $nombre_pais)
                        @php
                            $selected = old('pais_id') == $value ? 'selected' : '';
                        @endphp
                        <option value="{{ $value }}" {{ $selected }}>
                            {{ $nombre_pais }}
                        </option>    
                    @endforeach
                </select>
            </div>

            <div class="col-span-2">
                <x-label
                    for="direccion"
                    :value="__('Dirección')"
                />

                <x-input
                    id="direccion"
                    class="block mt-1 w-full"
                    type="text"
                    name="direccion"
                    :value="old('direccion')"
                    required
                    maxlength="200"
                />
            </div>

            <div>
                <x-label
                    for="region"
                    :value="__('Región')"
                />

                <x-input
                    id="region"
                    class="block mt-1 w-full"
                    type="text"
                    name="region"
                    :value="old('region')"
                    required
                    maxlength="100"
                />
            </div>

            <div>
                <x-label
                    for="capital"
                    :value="__('Capital')"
                />

                <x-input
                    id="capital"
                    class="block mt-1 w-full"
                    type="text"
                    name="capital"
                    :value="old('capital')"
                    required
                    maxlength="100"
                />
            </div>

            <div class="col-span-2">
                <x-label
                    for="visitor"
                    :value="__('Visitador')"
                />

                <select
                    name="visitor_id"
                    id="visitor"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full h-10 text-sm"
                    required
                >
                    <option value="">
                        Seleccionar
                    </option>
                    @php
                        $visitadores = [
                            1 => 'Fernando José Hernández López',
                            2 => 'María Alejandra Lutín'
                        ];
                    @endphp

                    @foreach ($visitadores as $value => $nombre_visitador)
                        @php
                            $selected = old('visitor_id') == $value ? 'selected' : '';
                        @endphp
                        <option value="{{ $value }}" {{ $selected }}>
                            {{ $nombre_visitador }}
                        </option>    
                    @endforeach
                </select>
            </div>

            <div class="col-span-2 flex flex-col items-start gap-4 mt-2">
                {{-- <a
                    class="w-full bg-secondary text-dark font-semibold rounded-md text-sm px-4 py-2 hover:brightness-[1.10] focus:ring-4 focus:ring-light  text-center"
                    href="{{ route('ingresa') }}"
                >
                    {{ __('Registrarme') }}
                </a> --}}

                <x-button class="w-full">
                    {{ __('Registrarme') }}
                </x-button>

                <a class="text-sm text-complementary-light hover:text-light" href="{{ route('ingresa') }}">
                    {{ __('Ya estoy registrado') }}
                </a>
            </div>
        </form>
    </x-auth-card>

    <div
        id="terms-conditions" 
        class="hidden overflow-hidden fixed top-0 right-0 left-0 z-50 w-screen inset-0 min-h-screen bg-[gray-800] bg-opacity-50 backdrop-blur-sm"
    >
        <div class="relative w-full min-h-screen flex justify-center items-center">
            <div class="relative rounded-sm shadow p-6 h-full bg-complementary-primary border border-white flex flex-col items-center justify-center w-full max-w-2xl text-center">
                <p class="text-lg mb-6">
                    Antes de continuar lee cuidadosamente el siguiente documento de Términos y Condiciones para participar en el sistema de Quiniela
                </p>

                <div class="flex justify-between rounded-md overflow-hidden mb-6">
                    <a
                        class="w-full flex items-center gap-3 text-sm text-light py-3 px-3 bg-primary hover:brightness-[1.20]"
                        href="/docs/terminos-y-condiciones-donovan.pdf"
                        target="_blank"
                    >
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><path fill="#909090" d="m24.1 2.072l5.564 5.8v22.056H8.879V30h20.856V7.945z"/><path fill="#f4f4f4" d="M24.031 2H8.808v27.928h20.856V7.873z"/><path fill="#7a7b7c" d="M8.655 3.5h-6.39v6.827h20.1V3.5z"/><path fill="#dd2025" d="M22.472 10.211H2.395V3.379h20.077z"/><path fill="#464648" d="M9.052 4.534H7.745v4.8h1.028V7.715L9 7.728a2 2 0 0 0 .647-.117a1.4 1.4 0 0 0 .493-.291a1.2 1.2 0 0 0 .335-.454a2.1 2.1 0 0 0 .105-.908a2.2 2.2 0 0 0-.114-.644a1.17 1.17 0 0 0-.687-.65a2 2 0 0 0-.409-.104a2 2 0 0 0-.319-.026m-.189 2.294h-.089v-1.48h.193a.57.57 0 0 1 .459.181a.92.92 0 0 1 .183.558c0 .246 0 .469-.222.626a.94.94 0 0 1-.524.114m3.671-2.306c-.111 0-.219.008-.295.011L12 4.538h-.78v4.8h.918a2.7 2.7 0 0 0 1.028-.175a1.7 1.7 0 0 0 .68-.491a1.9 1.9 0 0 0 .373-.749a3.7 3.7 0 0 0 .114-.949a4.4 4.4 0 0 0-.087-1.127a1.8 1.8 0 0 0-.4-.733a1.6 1.6 0 0 0-.535-.4a2.4 2.4 0 0 0-.549-.178a1.3 1.3 0 0 0-.228-.017m-.182 3.937h-.1V5.392h.013a1.06 1.06 0 0 1 .6.107a1.2 1.2 0 0 1 .324.4a1.3 1.3 0 0 1 .142.526c.009.22 0 .4 0 .549a3 3 0 0 1-.033.513a1.8 1.8 0 0 1-.169.5a1.1 1.1 0 0 1-.363.36a.67.67 0 0 1-.416.106m5.08-3.915H15v4.8h1.028V7.434h1.3v-.892h-1.3V5.43h1.4v-.892"/><path fill="#dd2025" d="M21.781 20.255s3.188-.578 3.188.511s-1.975.646-3.188-.511m-2.357.083a7.5 7.5 0 0 0-1.473.489l.4-.9c.4-.9.815-2.127.815-2.127a14 14 0 0 0 1.658 2.252a13 13 0 0 0-1.4.288Zm-1.262-6.5c0-.949.307-1.208.546-1.208s.508.115.517.939a10.8 10.8 0 0 1-.517 2.434a4.4 4.4 0 0 1-.547-2.162Zm-4.649 10.516c-.978-.585 2.051-2.386 2.6-2.444c-.003.001-1.576 3.056-2.6 2.444M25.9 20.895c-.01-.1-.1-1.207-2.07-1.16a14 14 0 0 0-2.453.173a12.5 12.5 0 0 1-2.012-2.655a11.8 11.8 0 0 0 .623-3.1c-.029-1.2-.316-1.888-1.236-1.878s-1.054.815-.933 2.013a9.3 9.3 0 0 0 .665 2.338s-.425 1.323-.987 2.639s-.946 2.006-.946 2.006a9.6 9.6 0 0 0-2.725 1.4c-.824.767-1.159 1.356-.725 1.945c.374.508 1.683.623 2.853-.91a23 23 0 0 0 1.7-2.492s1.784-.489 2.339-.623s1.226-.24 1.226-.24s1.629 1.639 3.2 1.581s1.495-.939 1.485-1.035"/><path fill="#909090" d="M23.954 2.077V7.95h5.633z"/><path fill="#f4f4f4" d="M24.031 2v5.873h5.633z"/><path fill="#fff" d="M8.975 4.457H7.668v4.8H8.7V7.639l.228.013a2 2 0 0 0 .647-.117a1.4 1.4 0 0 0 .493-.291a1.2 1.2 0 0 0 .332-.454a2.1 2.1 0 0 0 .105-.908a2.2 2.2 0 0 0-.114-.644a1.17 1.17 0 0 0-.687-.65a2 2 0 0 0-.411-.105a2 2 0 0 0-.319-.026m-.189 2.294h-.089v-1.48h.194a.57.57 0 0 1 .459.181a.92.92 0 0 1 .183.558c0 .246 0 .469-.222.626a.94.94 0 0 1-.524.114m3.67-2.306c-.111 0-.219.008-.295.011l-.235.006h-.78v4.8h.918a2.7 2.7 0 0 0 1.028-.175a1.7 1.7 0 0 0 .68-.491a1.9 1.9 0 0 0 .373-.749a3.7 3.7 0 0 0 .114-.949a4.4 4.4 0 0 0-.087-1.127a1.8 1.8 0 0 0-.4-.733a1.6 1.6 0 0 0-.535-.4a2.4 2.4 0 0 0-.549-.178a1.3 1.3 0 0 0-.228-.017m-.182 3.937h-.1V5.315h.013a1.06 1.06 0 0 1 .6.107a1.2 1.2 0 0 1 .324.4a1.3 1.3 0 0 1 .142.526c.009.22 0 .4 0 .549a3 3 0 0 1-.033.513a1.8 1.8 0 0 1-.169.5a1.1 1.1 0 0 1-.363.36a.67.67 0 0 1-.416.106m5.077-3.915h-2.43v4.8h1.028V7.357h1.3v-.892h-1.3V5.353h1.4v-.892"/></svg></span>
                        Términos y Condiciones
                    </a>

                    <a
                        class="flex items-center gap-2 py-3 px-3 bg-primary hover:brightness-[1.20]"
                        href="/docs/terminos-y-condiciones-donovan.pdf"
                        download
                    >
                        <span>
                            <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="currentColor" d="M3.5 13h9a.75.75 0 0 1 .102 1.493l-.102.007h-9a.75.75 0 0 1-.102-1.493zh9zM7.898 1.007L8 1a.75.75 0 0 1 .743.648l.007.102v7.688l2.255-2.254a.75.75 0 0 1 .977-.072l.084.072a.75.75 0 0 1 .072.977l-.072.084L8.53 11.78a.75.75 0 0 1-.976.073l-.084-.073l-3.536-3.535a.75.75 0 0 1 .977-1.133l.084.072L7.25 9.44V1.75a.75.75 0 0 1 .648-.743L8 1z"/></svg></span>
                        </span>
                    </a>
                </div>


                <p class="max-w-96 mb-4">
                    Al hacer click en el siguiente botón, aceptas plenamente los términos anteriormente expuestos
                </p>

                <button
                    id="btnAceptar"
                    onclick="hideElement(this.parentElement.parentElement.parentElement)"
                    class="hidden mx-auto bg-secondary text-dark font-semibold rounded-sm text-sm px-4 py-2 text-center hover:brightness-[1.10] focus:ring-4 focus:ring-light"
                >
                    Acepto los Términos y Condiciones
                </button>
                    <!--  
                <iframe
                    src="https://docs.google.com/viewer?srcid=1nys1ci4rHUr1bQSN1E9b3qXq4Wl2L-oA&pid=explorer&efh=false&a=v&chrome=false&embedded=true"
                    height="90%" width="100%" class="rounded-lg"></iframe>-->
                <div class="terminos" style="width: 95%; max-height: 95%; overflow: auto;">
                    <img src="https://medpharma.quinielacatar.com/terminos-1.jpg" style="    width: 100%;" alt="">
                    <img src="https://medpharma.quinielacatar.com/terminos-2.jpg" style="    width: 100%;" alt="">
                </div>
                
            </div>
        </div>
    </div>
</x-guest-layout>
