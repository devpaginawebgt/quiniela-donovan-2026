<x-app-layout>
    <x-inicio-header :activeTab="''" />

    <div class="max-w-screen-2xl my-6 mx-auto sm:px-6 lg:px-8 px-2">

        {{-- Título --}}
        <h1 class="text-3xl text-center font-bold mt-4 mb-2">Ranking de Participantes</h1>

        {{-- Subtítulo podio --}}
        <h2 id="podio-subtitle" class="text-xl text-center font-semibold mb-6 hidden">Primeros 3 Lugares</h2>

        {{-- Podio --}}
        <div id="podio" class="items-end justify-center gap-3 mb-8 px-4" style="display: none;">

            {{-- 2° lugar (izquierda) --}}
            <div class="w-full max-w-40">
                <div id="podio-2" style="display: none;" class="flex-col items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-[#C4C4C4] mb-1" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21v-2h4v-3.1q-1.225-.275-2.187-1.037T7.4 12.95q-1.875-.225-3.137-1.637T3 8V7q0-.825.588-1.412T5 5h2V3h10v2h2q.825 0 1.413.588T21 7v1q0 1.9-1.263 3.313T16.6 12.95q-.45 1.15-1.412 1.913T13 15.9V19h4v2zm0-10.2V7H5v1q0 .95.55 1.713T7 10.8m10 0q.9-.325 1.45-1.088T19 8V7h-2z"/></svg>
    
                    <p id="podio-2-name" class="text-sm font-semibold text-center leading-tight"></p>
    
                    <div class="border-t border-x border-secondary rounded-t-xl p-4 pt-8 w-full text-center lg:min-h-52" style="background: linear-gradient(var(--color-complementary-primary), 88%, transparent);">
                        <p class="text-2xl font-bold">2°</p>
                        <p id="podio-2-points" class="text-sm"></p>
                    </div>
                </div>
            </div>

            {{-- 1° lugar (centro, más alto) --}}
            <div class="w-full max-w-40">
                <div id="podio-1" style="display: none;" class="flex-col items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-[#EFBF04] mb-1" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21v-2h4v-3.1q-1.225-.275-2.187-1.037T7.4 12.95q-1.875-.225-3.137-1.637T3 8V7q0-.825.588-1.412T5 5h2V3h10v2h2q.825 0 1.413.588T21 7v1q0 1.9-1.263 3.313T16.6 12.95q-.45 1.15-1.412 1.913T13 15.9V19h4v2zm0-10.2V7H5v1q0 .95.55 1.713T7 10.8m10 0q.9-.325 1.45-1.088T19 8V7h-2z"/></svg>
    
                    <p id="podio-1-name" class="text-sm font-semibold text-center leading-tight"></p>
    
                    <div class="border-t border-x border-secondary rounded-t-xl p-4 pt-8 w-full text-center lg:min-h-72" style="background: linear-gradient(var(--color-complementary-primary), 93%, transparent);">
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-[#CE8946] mb-1" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21v-2h4v-3.1q-1.225-.275-2.187-1.037T7.4 12.95q-1.875-.225-3.137-1.637T3 8V7q0-.825.588-1.412T5 5h2V3h10v2h2q.825 0 1.413.588T21 7v1q0 1.9-1.263 3.313T16.6 12.95q-.45 1.15-1.412 1.913T13 15.9V19h4v2zm0-10.2V7H5v1q0 .95.55 1.713T7 10.8m10 0q.9-.325 1.45-1.088T19 8V7h-2z"/></svg>
    
                    <p id="podio-3-name" class="text-sm font-semibold text-center leading-tight"></p>
    
                    <div class="border-t border-x border-secondary rounded-t-xl p-4 pt-8 w-full text-center min-h-32" style="background: linear-gradient(var(--color-complementary-primary), 85%, transparent);">
                        <p class="text-2xl font-bold">3°</p>
                        <p id="podio-3-points" class="text-sm"></p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Patrocinadores (SSR) --}}
        @if($brands->count())
            <h6 class="text-xl text-center font-semibold mt-6 mb-4">Nuestros Patrocinadores</h6>
            <div class="overflow-x-auto pb-4 mb-6">
                <div class="flex md:justify-center gap-4 flex-nowrap px-2">
                    @foreach($brands as $brand)
                        <div class="min-w-40 bg-green-700 rounded-xl p-4 flex items-center justify-center shrink-0">
                            <img
                                src="{{ asset($brand->image) }}"
                                alt="{{ $brand->name }}"
                                class="w-full max-w-35 object-contain"
                            >
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Lista de ranking (cargada via Axios) --}}
        
        <h2 class="text-xl text-center font-semibold mb-6">Clasificación General</h2>

        <div id="ranking-list" class="flex flex-col md:items-center gap-2"></div>

        {{-- Loader --}}
        <div id="ranking-loader" class="flex justify-center py-8">
            <svg class="animate-spin h-8 w-8 text-secondary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
        </div>

        {{-- Empty state --}}
        <p id="ranking-empty" class="text-center text-complementary-light py-8 hidden">
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

                    if (el && nameEl && pointsEl) {
                        el.style.display = 'flex';
                        nameEl.textContent = p.nombres + ' ' + p.apellidos;
                        pointsEl.textContent = p.puntos + ' puntos';
                    }
                });
            }

            const medalSvg = `<span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 640 640"><path fill="currentColor" d="M320.3 192L235.7 51.1c-6.5-10.8-20.1-14.7-31.3-9.1l-86.6 43.3c-11.9 5.9-16.7 20.3-10.8 32.2l69.6 139.1c-30.1 33.9-48.3 78.5-48.3 127.4c0 106 86 192 192 192s192-86 192-192c0-48.9-18.3-93.5-48.3-127.4l69.6-139.1c5.9-11.9 1.1-26.3-10.7-32.2l-86.7-43.4c-11.2-5.6-24.9-1.6-31.3 9.1zm30.8 142.5c1.4 2.8 4 4.7 7 5.1l50.1 7.3c7.7 1.1 10.7 10.5 5.2 16l-36.3 35.4c-2.2 2.2-3.2 5.2-2.7 8.3l8.6 49.9c1.3 7.6-6.7 13.5-13.6 9.9l-44.8-23.6c-2.7-1.4-6-1.4-8.7 0l-44.8 23.6c-6.9 3.6-14.9-2.2-13.6-9.9l8.6-49.9c.5-3-.5-6.1-2.7-8.3l-36.3-35.4c-5.6-5.4-2.5-14.8 5.2-16l50.1-7.3c3-.4 5.7-2.4 7-5.1l22.4-45.4c3.4-7 13.3-7 16.8 0l22.4 45.4z"/></svg>
            </span>`;

            function renderList(participantes) {
                const html = participantes.map(function (p) {
                    let color = '#FFFFFF';
                    if (p.posicion === 1) color = '#EFBF04';
                    else if (p.posicion === 2) color = '#C4C4C4';
                    else if (p.posicion === 3) color = '#CE8946';

                    return '<div class="flex items-center gap-4 border border-secondary rounded-xl bg-complementary-primary px-4 py-3 w-full max-w-140">' +
                        '<span class="flex items-center gap-2 text-lg font-bold min-w-16" style="color: ' + color + '">' +
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

                axios.get('{{ route("web.users.ranking.data") }}', {
                    params: { page: page }
                })
                .then(function (response) {
                    const data = response.data.data;
                    const hasMore = response.data.has_more;

                    if (data.length === 0 && page === 1) {
                        emptyState.classList.remove('hidden');
                        return;
                    }

                    if (page === 1) {
                        renderPodio(data);
                        // Render all items in the list (including top 3)
                        renderList(data);
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
