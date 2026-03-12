/**
 * Inicializa el acordeón de estadísticas para las team-group-card.
 * Acepta un contenedor opcional para re-inicializar tras renders AJAX.
 */
export const initTeamGroupCardAccordion = (container = document) => {
    container.querySelectorAll('.team-group-card').forEach(card => {
        card.addEventListener('click', () => {
            const panel   = card.querySelector('.team-group-card-panel');
            const chevron = card.querySelector('.team-group-card-chevron');
            const isOpen  = card.getAttribute('aria-expanded') === 'true';

            if (isOpen) {
                panel.style.maxHeight = '0px';
                card.setAttribute('aria-expanded', 'false');
                chevron.style.transform = '';
            } else {
                panel.style.maxHeight = panel.scrollHeight + 'px';
                card.setAttribute('aria-expanded', 'true');
                chevron.style.transform = 'rotate(180deg)';
            }
        });
    });
};

/**
 * Genera el HTML de una team-group-card para renders AJAX.
 */
export const buildTeamGroupCard = (equipo) => {
    const statLabels = ['PJ', 'PG', 'PE', 'PP', 'GF', 'GC'];
    const statsRows = statLabels.map(label => {
        const val = equipo.stats.find(s => s.name === label)?.value ?? 0;
        return `
            <div class="flex justify-between items-center py-2 border-b border-white/10">
                <span class="font-semibold text-sm text-white">${label}</span>
                <span class="text-sm text-white">${val}</span>
            </div>`;
    }).join('');

    return `
        <div class="team-group-card bg-complementary-primary border border-secondary rounded-3xl overflow-hidden cursor-pointer" data-nombre="${equipo.name}" aria-expanded="false">
            <div class="flex items-center gap-4 p-4 pb-3">
                <img src="${equipo.image}" alt="${equipo.name}" class="h-16 w-24 object-cover rounded-2xl shrink-0 shadow-md">
                <span class="flex-1 font-bold text-right leading-tight text-white">${equipo.name}</span>
            </div>
            <div class="flex items-center justify-between px-4 pb-3">
                <span class="font-semibold text-white text-sm">Estadísticas</span>
                <svg class="team-group-card-chevron w-4 h-4 text-gray-400 shrink-0 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </div>
            <div class="team-group-card-panel max-h-0 overflow-hidden transition-[max-height] duration-300 ease-in-out">
                <div class="px-4 pb-4">
                    <div class="border-t border-white/10 pt-3">
                        <div class="flex flex-col">
                            ${statsRows}
                            <div class="flex justify-between items-center py-2">
                                <span class="font-bold text-white">Puntos</span>
                                <span class="font-bold text-white">${equipo.puntos}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
};
