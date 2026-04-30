<x-app-layout>
    <x-inicio-header :activeTab="''" />

    <div class="max-w-screen-2xl mx-auto mb-6 px-4 lg:px-8 pt-8">

        {{-- Título --}}
        <h1 class="text-2xl lg:text-3xl text-center font-bold mb-4">Ranking de Participantes</h1>

        {{-- Subtítulo podio --}}
        <h2 id="podio-subtitle" class="text-lg lg:text-xl text-center font-semibold mb-6 hidden">Primeros 3 Lugares</h2>

        {{-- Podio --}}
        <div id="podio" class="items-end justify-center gap-3 mb-8" style="display: none;">

            {{-- 2° lugar (izquierda) --}}
            <div class="w-full max-w-40">
                <div id="podio-2" style="display: none;" class="flex-col items-center">
                    <span id="podio-2-trophy">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" viewBox="0 0 640 640"><path fill="currentColor" d="M208.3 64h224c26.5 0 48.1 21.8 47.1 48.2c-.2 5.3-.4 10.6-.7 15.8h49.6c26.1 0 49.1 21.6 47.1 49.8c-7.5 103.7-60.5 160.7-118 190.5c-15.8 8.2-31.9 14.3-47.2 18.8c-20.2 28.6-41.2 43.7-57.9 51.8V512h64c17.7 0 32 14.3 32 32s-14.3 32-32 32h-192c-17.7 0-32-14.3-32-32s14.3-32 32-32h64v-73.1c-16-7.7-35.9-22-55.3-48.3c-18.4-4.8-38.4-12.1-57.9-23.1C121 337.2 72.2 280.1 65.2 177.6c-1.9-28.1 21-49.7 47.1-49.7h49.6c-.3-5.2-.5-10.4-.7-15.8c-1-26.5 20.6-48.2 47.1-48.2zm-42.8 112h-52.4c6.2 84.7 45.1 127.1 85.2 149.6c-14.4-37.3-26.3-86-32.8-149.6M444 320.8c40.5-23.8 77.1-66.1 83.3-144.8H475c-6.2 60.9-17.4 108.2-31 144.8"/></svg>
                    </span>

                    <p id="podio-2-name" class="text-sm xl:text-base font-semibold text-center leading-tight my-1"></p>
    
                    <div class="border-t border-x border-secondary rounded-t-xl p-2 sm:p-4 pt-8 w-full text-center h-40 lg:h-52" style="background: linear-gradient(var(--color-complementary-primary), 88%, transparent);">
                        <p class="text-2xl font-bold">2°</p>
                        <p id="podio-2-points" class="text-sm"></p>
                    </div>
                </div>
            </div>

            {{-- 1° lugar (centro, más alto) --}}
            <div class="w-full max-w-40">
                <div id="podio-1" style="display: none;" class="flex-col items-center">
                    <span id="podio-1-trophy">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-18 h-18" viewBox="0 0 640 640"><path fill="currentColor" d="M208.3 64h224c26.5 0 48.1 21.8 47.1 48.2c-.2 5.3-.4 10.6-.7 15.8h49.6c26.1 0 49.1 21.6 47.1 49.8c-7.5 103.7-60.5 160.7-118 190.5c-15.8 8.2-31.9 14.3-47.2 18.8c-20.2 28.6-41.2 43.7-57.9 51.8V512h64c17.7 0 32 14.3 32 32s-14.3 32-32 32h-192c-17.7 0-32-14.3-32-32s14.3-32 32-32h64v-73.1c-16-7.7-35.9-22-55.3-48.3c-18.4-4.8-38.4-12.1-57.9-23.1C121 337.2 72.2 280.1 65.2 177.6c-1.9-28.1 21-49.7 47.1-49.7h49.6c-.3-5.2-.5-10.4-.7-15.8c-1-26.5 20.6-48.2 47.1-48.2zm-42.8 112h-52.4c6.2 84.7 45.1 127.1 85.2 149.6c-14.4-37.3-26.3-86-32.8-149.6M444 320.8c40.5-23.8 77.1-66.1 83.3-144.8H475c-6.2 60.9-17.4 108.2-31 144.8"/></svg>
                    </span>

                    <p id="podio-1-name" class="text-sm xl:text-base font-semibold text-center leading-tight my-1"></p>
    
                    <div class="border-t border-x border-secondary rounded-t-xl p-2 sm:p-4 pt-8 w-full text-center h-56 lg:h-72" style="background: linear-gradient(var(--color-complementary-primary), 93%, transparent);">
                        <p class="text-3xl font-bold">1°</p>
                        <p id="podio-1-points" class="text-sm font-semibold"></p>
                        @if (isset($first_place_brand) && !empty($first_place_brand))
                            <div class="mt-4">
                                <img src="{{ asset($first_place_brand->image) }}" alt="">
                            </div>
                        @endif
                    </div>

                </div>
            </div>

            {{-- 3° lugar (derecha) --}}
            <div class="w-full max-w-40">
                <div id="podio-3" style="display: none;" class="flex-col items-center">
                    <span id="podio-3-trophy">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" viewBox="0 0 640 640"><path fill="currentColor" d="M208.3 64h224c26.5 0 48.1 21.8 47.1 48.2c-.2 5.3-.4 10.6-.7 15.8h49.6c26.1 0 49.1 21.6 47.1 49.8c-7.5 103.7-60.5 160.7-118 190.5c-15.8 8.2-31.9 14.3-47.2 18.8c-20.2 28.6-41.2 43.7-57.9 51.8V512h64c17.7 0 32 14.3 32 32s-14.3 32-32 32h-192c-17.7 0-32-14.3-32-32s14.3-32 32-32h64v-73.1c-16-7.7-35.9-22-55.3-48.3c-18.4-4.8-38.4-12.1-57.9-23.1C121 337.2 72.2 280.1 65.2 177.6c-1.9-28.1 21-49.7 47.1-49.7h49.6c-.3-5.2-.5-10.4-.7-15.8c-1-26.5 20.6-48.2 47.1-48.2zm-42.8 112h-52.4c6.2 84.7 45.1 127.1 85.2 149.6c-14.4-37.3-26.3-86-32.8-149.6M444 320.8c40.5-23.8 77.1-66.1 83.3-144.8H475c-6.2 60.9-17.4 108.2-31 144.8"/></svg>
                    </span>

                    <p id="podio-3-name" class="text-sm xl:text-base font-semibold text-center leading-tight my-1"></p>
    
                    <div class="border-t border-x border-secondary rounded-t-xl p-2 sm:p-4 pt-8 w-full text-center h-28 lg:h-32" style="background: linear-gradient(var(--color-complementary-primary), 85%, transparent);">
                        <p class="text-2xl font-bold">3°</p>
                        <p id="podio-3-points" class="text-sm"></p>
                    </div>
                </div>
            </div>

        </div>

        <x-brands-slider :brands="$brands" />

        {{-- Lista de ranking (cargada via Axios) --}}
        
        <h2 class="text-lg lg:text-xl text-center font-semibold mt-8 mb-6">Clasificación General</h2>

        <div class="max-h-[60vh] max-w-148 mx-auto overflow-y-auto rounded-xl">
            <div id="ranking-list" class="flex flex-col md:items-center gap-2"></div>

            {{-- Loader --}}
            <div id="ranking-loader" class="flex justify-center py-8">
                <svg class="animate-spin h-8 w-8 text-secondary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
            </div>

            {{-- Empty state --}}
            <p id="ranking-empty" class="text-center text-complementary-light py-4 hidden">
                No hay participantes para mostrar
            </p>

            {{-- Load more --}}
            <div class="flex justify-center mt-4 mb-6">
                <button id="btn-cargar-mas"
                    class="hidden bg-secondary text-dark font-semibold px-6 py-2.5 rounded-full hover:bg-secondary/80 transition-colors">
                    Cargar más
                </button>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const rankingList = document.getElementById('ranking-list');
            const loader = document.getElementById('ranking-loader');
            const emptyState = document.getElementById('ranking-empty');
            const btnCargarMas = document.getElementById('btn-cargar-mas');
            const podio = document.getElementById('podio');
            const podioSubtitle = document.getElementById('podio-subtitle');

            let currentPage = 1;
            let loading = false;

            function renderPodio(participantes) {
                const top3 = participantes.filter(function (p) { return p.posicion <= 3; });

                if (top3.length === 0) return;

                podio.style.display = 'flex';
                podioSubtitle.classList.remove('hidden');

                top3.forEach(function (p) {
                    const el = document.getElementById('podio-' + p.posicion);
                    const nameEl = document.getElementById('podio-' + p.posicion + '-name');
                    const pointsEl = document.getElementById('podio-' + p.posicion + '-points');
                    const trophyEl = document.getElementById('podio-' + p.posicion + '-trophy');

                    if (el && nameEl && pointsEl) {
                        el.style.display = 'flex';
                        nameEl.textContent = p.nombres + ' ' + p.apellidos;
                        pointsEl.textContent = p.puntos + ' puntos';

                        if (trophyEl) {
                            trophyEl.style.color = p.color;
                        }
                    }
                });
            }

            const medalSvg = `<span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 640 640"><path fill="currentColor" d="M320.3 192L235.7 51.1c-6.5-10.8-20.1-14.7-31.3-9.1l-86.6 43.3c-11.9 5.9-16.7 20.3-10.8 32.2l69.6 139.1c-30.1 33.9-48.3 78.5-48.3 127.4c0 106 86 192 192 192s192-86 192-192c0-48.9-18.3-93.5-48.3-127.4l69.6-139.1c5.9-11.9 1.1-26.3-10.7-32.2l-86.7-43.4c-11.2-5.6-24.9-1.6-31.3 9.1zm30.8 142.5c1.4 2.8 4 4.7 7 5.1l50.1 7.3c7.7 1.1 10.7 10.5 5.2 16l-36.3 35.4c-2.2 2.2-3.2 5.2-2.7 8.3l8.6 49.9c1.3 7.6-6.7 13.5-13.6 9.9l-44.8-23.6c-2.7-1.4-6-1.4-8.7 0l-44.8 23.6c-6.9 3.6-14.9-2.2-13.6-9.9l8.6-49.9c.5-3-.5-6.1-2.7-8.3l-36.3-35.4c-5.6-5.4-2.5-14.8 5.2-16l50.1-7.3c3-.4 5.7-2.4 7-5.1l22.4-45.4c3.4-7 13.3-7 16.8 0l22.4 45.4z"/></svg>
            </span>`;

            function renderList(participantes) {
                const html = participantes.map(function (p) {
                    return '<div class="flex items-center gap-4 border border-secondary rounded-xl bg-complementary-primary px-4 py-3 w-full max-w-140">' +
                        '<span class="flex items-center gap-2 text-lg font-bold min-w-16" style="color: ' + p.color + '">' +
                            medalSvg + p.posicion + ' °' +
                        '</span>' +
                        '<div class="flex-1 min-w-0">' +
                            '<p class="font-semibold truncate">' + p.nombres + ' ' + p.apellidos + '</p>' +
                        '</div>' +
                        '<span class="text-light font-bold shrink-0">' + p.puntos + ' puntos</span>' +
                    '</div>';
                }).join('');

                rankingList.insertAdjacentHTML('beforeend', html);
            }

            function fetchRanking(page) {
                if (loading) return;
                loading = true;

                loader.classList.remove('hidden');
                btnCargarMas.classList.add('hidden');

                axios.get('{{ route("web.ranking.grupos") }}', {
                    params: { page: page }
                })
                .then(function (response) {
                    const data = response.data.data.users;
                    const hasMore = response.data.data.has_more;

                    if (data.length === 0 && page === 1) {
                        emptyState.classList.remove('hidden');
                        return;
                    }

                    if (page === 1) {
                        renderPodio(data);
                        const rest = data.filter(function (p) { return p.posicion > 3; });
                        if (rest.length > 0) {
                            renderList(rest);
                        } else if (!hasMore) {
                            emptyState.classList.remove('hidden');
                        }
                    } else {
                        renderList(data);
                    }

                    if (hasMore) {
                        btnCargarMas.classList.remove('hidden');
                    }

                    currentPage = page;
                })
                .catch(function (error) {
                    console.error('Error cargando ranking:', error);
                })
                .finally(function () {
                    loading = false;
                    loader.classList.add('hidden');
                });
            }

            btnCargarMas.addEventListener('click', function () {
                fetchRanking(currentPage + 1);
            });

            fetchRanking(1);
        });
    </script>

</x-app-layout>
