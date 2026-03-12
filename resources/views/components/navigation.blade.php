<input type="hidden" id="user_id" value="{{ Auth::user()->id }}">

{{-- Bottom Navigation Bar --}}
<nav class="fixed bottom-0 left-0 right-0 z-40 bg-complementary-primary border-t border-secondary">
    <div class="flex justify-around items-center h-16 max-w-lg mx-auto px-4">

        {{-- Inicio --}}
        <a href="{{ route('web.inicio') }}"
           class="flex flex-col items-center gap-1 text-xs font-medium transition-colors duration-150
                  {{ request()->routeIs('web.inicio') ? 'text-complementary-light' : 'text-complementary-light hover:text-secondary' }}">
            @if (request()->routeIs('web.inicio'))
                <span class="bg-secondary rounded-full px-3 py-1 flex items-center gap-1 text-complementary-primary">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 lg:w-6 lg:h-6"
                        viewBox="0 0 24 24"><path
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="m2.25 12l8.955-8.955a1.124 1.124 0 0 1 1.59 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
                    /></svg>
                </span>
                Inicio
            @else
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 lg:w-6 lg:h-6"
                    viewBox="0 0 24 24"><path
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="m2.25 12l8.955-8.955a1.124 1.124 0 0 1 1.59 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
                /></svg>
                <span>Inicio</span>
            @endif
        </a>

        {{-- Clasificación --}}
        <a href="{{ route('web.users.ranking') }}"
           class="flex flex-col items-center gap-1 text-xs font-medium transition-colors duration-150
                  {{ request()->routeIs('web.users.ranking') ? 'text-complementary-light' : 'text-complementary-light hover:text-secondary' }}">
            @if (request()->routeIs('web.users.ranking'))
                <span class="bg-secondary rounded-full px-3 py-1 flex items-center gap-1 text-complementary-primary">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 lg:w-6 lg:h-6"
                        viewBox="0 0 640 512"><path
                        fill="currentColor"
                        d="M353.8 54.1L330.2 6.3c-3.9-8.3-16.1-8.6-20.4 0l-23.6 47.8l-52.3 7.5c-9.3 1.4-13.3 12.9-6.4 19.8l38 37l-9 52.1c-1.4 9.3 8.2 16.5 16.8 12.2l46.9-24.8l46.6 24.4c8.6 4.3 18.3-2.9 16.8-12.2l-9-52.1l38-36.6c6.8-6.8 2.9-18.3-6.4-19.8l-52.3-7.5zM256 256c-17.7 0-32 14.3-32 32v192c0 17.7 14.3 32 32 32h128c17.7 0 32-14.3 32-32V288c0-17.7-14.3-32-32-32zM32 320c-17.7 0-32 14.3-32 32v128c0 17.7 14.3 32 32 32h128c17.7 0 32-14.3 32-32V352c0-17.7-14.3-32-32-32zm416 96v64c0 17.7 14.3 32 32 32h128c17.7 0 32-14.3 32-32v-64c0-17.7-14.3-32-32-32H480c-17.7 0-32 14.3-32 32"
                    /></svg>
                </span>
                Clasificación
            @else
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 lg:w-6 lg:h-6"
                    viewBox="0 0 640 512"><path
                    fill="currentColor"
                    d="M353.8 54.1L330.2 6.3c-3.9-8.3-16.1-8.6-20.4 0l-23.6 47.8l-52.3 7.5c-9.3 1.4-13.3 12.9-6.4 19.8l38 37l-9 52.1c-1.4 9.3 8.2 16.5 16.8 12.2l46.9-24.8l46.6 24.4c8.6 4.3 18.3-2.9 16.8-12.2l-9-52.1l38-36.6c6.8-6.8 2.9-18.3-6.4-19.8l-52.3-7.5zM256 256c-17.7 0-32 14.3-32 32v192c0 17.7 14.3 32 32 32h128c17.7 0 32-14.3 32-32V288c0-17.7-14.3-32-32-32zM32 320c-17.7 0-32 14.3-32 32v128c0 17.7 14.3 32 32 32h128c17.7 0 32-14.3 32-32V352c0-17.7-14.3-32-32-32zm416 96v64c0 17.7 14.3 32 32 32h128c17.7 0 32-14.3 32-32v-64c0-17.7-14.3-32-32-32H480c-17.7 0-32 14.3-32 32"
                /></svg>
                <span>Clasificación</span>
            @endif
        </a>

        {{-- Recompensas --}}
        <a href="{{ route('web.ver-tabla-premios') }}"
           class="flex flex-col items-center gap-1 text-xs font-medium transition-colors duration-150
                  {{ request()->routeIs('web.ver-tabla-premios') ? 'text-complementary-light' : 'text-complementary-light hover:text-secondary' }}">
            @if (request()->routeIs('web.ver-tabla-premios'))
                <span class="bg-secondary rounded-full px-3 py-1 flex items-center gap-1 text-complementary-primary">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 lg:w-6 lg:h-6"
                        viewBox="0 0 24 24"><path
                        fill="currentColor"
                        d="M7 21v-2h4v-3.1q-1.225-.275-2.187-1.037T7.4 12.95q-1.875-.225-3.137-1.637T3 8V5h4V3h10v2h4v3q0 1.9-1.263 3.313T16.6 12.95q-.45 1.15-1.412 1.913T13 15.9V19h4v2zm0-10.2V7H5v1q0 .95.55 1.713T7 10.8m10 0q.9-.325 1.45-1.088T19 8V7h-2z"
                    /></svg>
                </span>
                Recompensas
            @else
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 lg:w-6 lg:h-6"
                    viewBox="0 0 24 24"><path
                    fill="currentColor"
                    d="M7 21v-2h4v-3.1q-1.225-.275-2.187-1.037T7.4 12.95q-1.875-.225-3.137-1.637T3 8V5h4V3h10v2h4v3q0 1.9-1.263 3.313T16.6 12.95q-.45 1.15-1.412 1.913T13 15.9V19h4v2zm0-10.2V7H5v1q0 .95.55 1.713T7 10.8m10 0q.9-.325 1.45-1.088T19 8V7h-2z"
                /></svg>
                <span>Recompensas</span>
            @endif
        </a>

        {{-- Perfil --}}
        <a href="{{ route('web.perfil') }}"
           class="flex flex-col items-center gap-1 text-xs font-medium transition-colors duration-150
                  {{ request()->routeIs('web.perfil') ? 'text-complementary-light' : 'text-complementary-light hover:text-secondary' }}">
            @if (request()->routeIs('web.perfil'))
                <span class="bg-secondary rounded-full px-3 py-1 flex items-center gap-1 text-complementary-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 lg:w-6 lg:h-6" viewBox="0 0 512 512"><path fill="currentColor" fill-rule="evenodd" d="m392.18 256l.001 22.836a88.8 88.8 0 0 1 28.134 16.268l19.797-11.43l29.63 51.32l-19.784 11.423a89.4 89.4 0 0 1 1.482 16.25c0 5.55-.509 10.982-1.482 16.25l19.784 11.423l-29.63 51.32l-19.797-11.43a88.8 88.8 0 0 1-28.134 16.268v22.836h-59.26v-22.836a88.8 88.8 0 0 1-28.134-16.267l-19.797 11.43l-29.63-51.32l19.784-11.424a89.4 89.4 0 0 1-1.482-16.25c0-5.55.509-10.982 1.482-16.251l-19.784-11.422l29.63-51.32l19.796 11.43a88.8 88.8 0 0 1 28.135-16.268V256zm-141.513-21.333c19.434 0 37.713 5.092 53.644 14.049c-41.352 21.217-69.644 64.28-69.644 113.951c0 23.314 6.233 45.172 17.123 64H64v-76.8c0-62.033 47.668-112.614 107.383-115.104l4.617-.096zm111.884 92.444c-19.637 0-35.556 15.92-35.556 35.556c0 19.637 15.92 35.556 35.556 35.556c19.637 0 35.555-15.92 35.555-35.556c0-19.637-15.918-35.556-35.555-35.556M213.333 42.667c41.238 0 74.667 33.43 74.667 74.667c0 39.862-31.238 72.429-70.57 74.556l-4.097.11c-41.237 0-74.666-33.43-74.666-74.666c0-39.863 31.238-72.43 70.57-74.557z"/></svg>
                </span>
                Perfil
            @else
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 lg:w-6 lg:h-6" viewBox="0 0 512 512"><path fill="currentColor" fill-rule="evenodd" d="m392.18 256l.001 22.836a88.8 88.8 0 0 1 28.134 16.268l19.797-11.43l29.63 51.32l-19.784 11.423a89.4 89.4 0 0 1 1.482 16.25c0 5.55-.509 10.982-1.482 16.25l19.784 11.423l-29.63 51.32l-19.797-11.43a88.8 88.8 0 0 1-28.134 16.268v22.836h-59.26v-22.836a88.8 88.8 0 0 1-28.134-16.267l-19.797 11.43l-29.63-51.32l19.784-11.424a89.4 89.4 0 0 1-1.482-16.25c0-5.55.509-10.982 1.482-16.251l-19.784-11.422l29.63-51.32l19.796 11.43a88.8 88.8 0 0 1 28.135-16.268V256zm-141.513-21.333c19.434 0 37.713 5.092 53.644 14.049c-41.352 21.217-69.644 64.28-69.644 113.951c0 23.314 6.233 45.172 17.123 64H64v-76.8c0-62.033 47.668-112.614 107.383-115.104l4.617-.096zm111.884 92.444c-19.637 0-35.556 15.92-35.556 35.556c0 19.637 15.92 35.556 35.556 35.556c19.637 0 35.555-15.92 35.555-35.556c0-19.637-15.918-35.556-35.555-35.556M213.333 42.667c41.238 0 74.667 33.43 74.667 74.667c0 39.862-31.238 72.429-70.57 74.556l-4.097.11c-41.237 0-74.666-33.43-74.666-74.666c0-39.863 31.238-72.43 70.57-74.557z"/></svg>
                </svg>
                <span>Perfil</span>
            @endif
        </a>

    </div>
</nav>
