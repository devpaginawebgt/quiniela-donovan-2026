{{-- Fixed navigation buttons --}}
<div class="fixed top-4 left-4 z-50 flex gap-2">
    <button type="button"
            data-scroll-to-start
            class="bracket-scroll-btn flex items-center gap-2 bg-secondary text-dark text-sm font-semibold px-3 py-2 rounded-full shadow-lg hover:bg-yellow-400 transition-colors">
        <span class="icon-[material-symbols--first-page-rounded] w-4 h-4"></span>
        Inicio
    </button>
    <button type="button"
            data-scroll-to-active
            class="bracket-scroll-btn flex items-center gap-2 bg-secondary text-dark text-sm font-semibold px-3 py-2 rounded-full shadow-lg hover:bg-yellow-400 transition-colors">
        <span class="icon-[material-symbols--my-location-rounded] w-4 h-4"></span>
        Jornada actual
    </button>
</div>

<div id="bracket-scroll" class="min-h-screen p-6 pt-16 overflow-x-auto">
    {{-- Bracket principal --}}
    <div class="flex items-start gap-6" style="min-width: max-content;">
        <x-bracket.group-standings
            :grupos="$grupos"
            :jornadasGrupos="$jornadas->whereIn('id', [1, 2, 3])" />
        <x-bracket.round-of-32   :partidos="$rondas[4] ?? collect()" :jornada="$jornadas[4] ?? null" />
        <x-bracket.round-of-16   :partidos="$rondas[5] ?? collect()" :jornada="$jornadas[5] ?? null" />
        <x-bracket.quarterfinals :partidos="$rondas[6] ?? collect()" :jornada="$jornadas[6] ?? null" />
        <x-bracket.semifinals    :partidos="$rondas[7] ?? collect()" :jornada="$jornadas[7] ?? null" />
        <x-bracket.final
            :tercer="($rondas[8] ?? collect())->first()"
            :partido="($rondas[9] ?? collect())->first()"
            :jornadaTercer="$jornadas[8] ?? null"
            :jornadaFinal="$jornadas[9] ?? null"
        />
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('bracket-scroll');
        if (!container) return;

        const scrollToElement = (el) => {
            if (!el) return;
            const rect = el.getBoundingClientRect();
            const containerRect = container.getBoundingClientRect();

            const left = rect.left - containerRect.left + container.scrollLeft - 160;
            container.scrollTo({ left: Math.max(0, left), behavior: 'smooth' });

            const top = rect.top + window.scrollY - 80;
            window.scrollTo({ top: Math.max(0, top), behavior: 'smooth' });
        };

        document.querySelectorAll('.bracket-scroll-btn').forEach((btn) => {
            btn.addEventListener('click', () => {
                if ('scrollToStart' in btn.dataset) {
                    container.scrollTo({ left: 0, behavior: 'smooth' });
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                } else if (btn.dataset.scrollTo) {
                    scrollToElement(document.querySelector(btn.dataset.scrollTo));
                } else if ('scrollToActive' in btn.dataset) {
                    scrollToElement(document.querySelector('[data-active="1"]'));
                }
            });
        });
    });
</script>
