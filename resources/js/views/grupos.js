import { initTeamGroupCardAccordion, buildTeamGroupCard } from '../components/team-group-card.js';
import { renderMatchCard } from '../components/match-card.js';

// --- Jornadas ---

const filtrarPartidosGrupo = (query) => {
    const cards = document.querySelectorAll('#jornadas-partidos-list .match-card');
    const term  = query.toLowerCase().trim();
    cards.forEach(card => {
        const equipos = card.getAttribute('data-equipos') ?? '';
        card.style.display = equipos.includes(term) ? '' : 'none';
    });
};

const renderJornadasGrupo = (jornadas) => {
    const contenedor = document.getElementById('jornadas-partidos-list');

    contenedor.innerHTML = jornadas.map(jornada => `
        <div class="mb-8">
            <h6 class="text-xl font-semibold text-center mb-4">Jornada ${jornada.value}</h6>
            <ul class="flex flex-wrap justify-center gap-4">
                ${jornada.partidos.map(renderMatchCard).join('')}
            </ul>
        </div>
    `).join('');

    const buscar = document.getElementById('buscar-partidos-grupo');
    if (buscar?.value.trim()) {
        filtrarPartidosGrupo(buscar.value.trim());
    }
};

const cargarJornadasGrupo = async (grupoId, grupoNombre) => {
    const spinner    = document.getElementById('jornadas-spinner');
    const tituloJorn = document.getElementById('titulo-jornadas-grupo');

    tituloJorn.textContent = `Jornadas de Partidos del Grupo ${grupoNombre}`;
    spinner?.classList.remove('hidden');

    try {
        const res      = await window.axios.get(`/grupos/${grupoId}/jornadas`);
        const jornadas = res.data.data;
        renderJornadasGrupo(jornadas);
    } catch (e) {
        console.error(e);
    } finally {
        spinner?.classList.add('hidden');
    }
};

document.addEventListener('DOMContentLoaded', () => {

    initTeamGroupCardAccordion();

    // --- Group selector ---

    const selectorGrupo = document.getElementById('selector-grupo');
    const listaEquipos  = document.getElementById('equipos-grupo-list');
    const tituloGrupo   = document.getElementById('titulo-grupo');
    const spinner       = document.getElementById('grupos-spinner');

    if (selectorGrupo) {
        selectorGrupo.addEventListener('change', async function () {
            const grupoId     = this.value;
            const grupoNombre = this.options[this.selectedIndex].text;

            spinner?.classList.remove('hidden');
            listaEquipos.innerHTML = '';
            tituloGrupo.textContent = `Grupo ${grupoNombre}`;

            try {
                const res     = await window.axios.get(`/grupos/${grupoId}/equipos`);
                const equipos = res.data.data.equipos;

                listaEquipos.innerHTML = equipos.map(buildTeamGroupCard).join('');
                initTeamGroupCardAccordion(listaEquipos);

                const searchInput = document.getElementById('buscar-equipos');
                if (searchInput?.value.trim()) {
                    filterTeams(searchInput.value.toLowerCase().trim());
                }
            } catch (e) {
                console.error(e);
            } finally {
                spinner?.classList.add('hidden');
            }

            cargarJornadasGrupo(grupoId, grupoNombre);
        });
    }

    // --- Search filters ---

    const filterTeams = (term) => {
        document.querySelectorAll('.team-group-card').forEach(card => {
            card.style.display = card.dataset.nombre.toLowerCase().includes(term) ? '' : 'none';
        });
    };

    const searchInput = document.getElementById('buscar-equipos');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            filterTeams(this.value.toLowerCase().trim());
        });
    }

    const buscarPartidos = document.getElementById('buscar-partidos-grupo');
    if (buscarPartidos) {
        buscarPartidos.addEventListener('input', function () {
            filtrarPartidosGrupo(this.value);
        });
    }

    // --- Ver Jornadas toggle ---

    const btnVerJornadas  = document.getElementById('btn-ver-jornadas');
    const jornadasSection = document.getElementById('jornadas-section');

    if (btnVerJornadas && jornadasSection) {
        btnVerJornadas.addEventListener('click', () => {
            const isHidden = jornadasSection.classList.toggle('hidden');

            if (!isHidden) {
                const grupoId     = selectorGrupo?.value;
                const grupoNombre = selectorGrupo?.options[selectorGrupo.selectedIndex]?.text;
                cargarJornadasGrupo(grupoId, grupoNombre);
                jornadasSection.scrollIntoView({ behavior: 'smooth' });
            }
        });
    }

});
