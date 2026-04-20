<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">

    <title>{{ config('app.name', 'Quiniela') }} — Admin</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    @vite([
        'resources/css/app.css',
        'resources/css/styles.css',
        'resources/js/app.js',
        'resources/js/functions.js'
    ])
</head>
<body class="font-sans antialiased text-light bg-complementary-primary">

    {{-- Topbar móvil (botón para abrir sidebar) --}}
    <header class="lg:hidden fixed top-0 left-0 right-0 z-50 bg-complementary-primary border-b border-zinc-400">
        <div class="flex items-center justify-between px-4 h-14">
            {{-- Branding --}}
            <div class="flex items-center gap-2">
                <span class="icon-[material-symbols--person] w-6 h-6 text-secondary"></span>
                <span class="font-bold text-light text-sm">{{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}</span>
            </div>

            <button type="button"
                    data-drawer-target="admin-sidebar"
                    data-drawer-toggle="admin-sidebar"
                    data-drawer-placement="top"
                    data-drawer-backdrop="true"
                    data-drawer-body-scrolling="false"
                    aria-controls="admin-sidebar"
                    class="p-1 rounded-lg text-light hover:bg-complementary-primary focus:outline-none focus:ring-2 focus:ring-secondary flex justify-center items-center">
                <span class="sr-only">Abrir menú</span>
                <span class="icon-[material-symbols--menu-rounded] w-6 h-6"></span>
            </button>
        </div>
    </header>

    {{-- Sidebar --}}
    <aside id="admin-sidebar"
           tabindex="-1"
           class="fixed top-14 left-0 z-40 w-full max-h-[calc(100vh-3.5rem)] overflow-y-auto
                  lg:top-0 lg:max-h-none lg:min-h-screen lg:w-64
                  transition-transform -translate-y-full lg:translate-y-0
                  bg-complementary-primary border-r border-zinc-400"
           aria-label="Sidebar admin">

        <div class="flex flex-col h-full">

            {{-- Branding --}}
            <div class="hidden lg:flex items-center gap-2 px-4 h-16 border-b border-zinc-400">
                <span class="icon-[material-symbols--person] w-7 h-7 text-secondary"></span>
                <span class="font-bold text-light">{{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}</span>
            </div>

            {{-- Navegación --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4">
                <p class="px-2 mb-2 text-[10px] uppercase tracking-wider text-complementary-light">Módulos</p>

                <x-admin.navigation />
            </nav>

            {{-- Footer: volver al sitio + logout --}}
            <div class="px-3 py-3 border-t border-complementary-dark/30 space-y-1">
                <a href="{{ route('web.inicio.proximos-partidos') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-complementary-light hover:bg-complementary-primary/60 hover:text-light transition-colors">
                    <span class="icon-[material-symbols--arrow-back-rounded] w-5 h-5"></span>
                    <span>Volver al sitio</span>
                </a>

                <form method="POST" action="{{ route('web.logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-complementary-light hover:bg-complementary-primary/60 hover:text-light transition-colors">
                        <span class="icon-[material-symbols--logout-rounded] w-5 h-5"></span>
                        <span>Cerrar sesión</span>
                    </button>
                </form>
            </div>

        </div>
    </aside>

    {{-- Contenido principal --}}
    <div class="lg:ml-64 pt-14 lg:pt-0 min-h-screen">
        <main class="p-4 sm:p-6 lg:p-8">
            {{ $slot }}
        </main>
    </div>

</body>
</html>
