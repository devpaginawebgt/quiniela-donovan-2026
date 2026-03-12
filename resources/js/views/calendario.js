import { renderMatchCard } from '../components/match-card.js';

// --- HTTP ---
const fetchPartidosJornada = async (jornada) =>
    window.axios.get(`/jornadas/partidos-jornada/${jornada}`);

const filtrarMatchCards = (query) => {
    const cards = document.querySelectorAll('#partidos-jornada-general .match-card');
    const term  = query.toLowerCase().trim();
    cards.forEach(card => {
        const equipos = card.getAttribute('data-equipos') ?? '';
        card.style.display = equipos.includes(term) ? '' : 'none';
    });
};

const renderPartidosCalendario = (partidos) => {
    const espacioJornada = document.querySelector('#partidos-jornada-general');

    if (!partidos.length) {
        espacioJornada.innerHTML = `<p class="text-2xl text-complementary-light w-full text-center py-12 col-span-2">No hay partidos en esta jornada</p>`;
        return;
    }

    espacioJornada.innerHTML = partidos.map(renderMatchCard).join('');

    const buscar = document.getElementById('buscar-partidos');
    if (buscar && buscar.value.trim()) {
        filtrarMatchCards(buscar.value.trim());
    }
};

const cargarJornada = async (idJornada) => {
    try {
        const respuestaPartidos = await fetchPartidosJornada(idJornada);
        const partidos = respuestaPartidos.data.data;
        renderPartidosCalendario(partidos);
    } catch (err) {
        alert('Ocurrió un error al obtener los partidos de la jornada.');
        console.error(err);
    }
};

// --- Inicialización ---
document.addEventListener('DOMContentLoaded', () => {
    const inputCalendario = document.getElementById('jornadas');
    if (!inputCalendario) return;

    cargarJornada(inputCalendario.value);

    inputCalendario.addEventListener('change', function () {
        if (!this.value) return;
        cargarJornada(this.value);
    });

    const buscar = document.getElementById('buscar-partidos');
    if (buscar) {
        buscar.addEventListener('input', function () {
            filtrarMatchCards(this.value);
        });
    }
});
