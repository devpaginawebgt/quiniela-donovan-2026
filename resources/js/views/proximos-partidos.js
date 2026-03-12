import { initMarcadorButtons } from '../components/marcador.js';

initMarcadorButtons();

document.addEventListener('DOMContentLoaded', () => {

    // Logica para cambiar de jornada 

    const select = document.getElementById('select-proximos-partidos');

    if (!select) return;

    select.addEventListener('change', () => {
        document.getElementById('form-proximos-partidos').submit();
    });

    // Logica para filtrar los registros de predicciones en la vista

    const buscar = document.getElementById('buscar-partidos');
    const lista  = document.getElementById('partidos-jornada-general');

    if (buscar && lista) {
        buscar.addEventListener('input', function () {
            const term = this.value.toLowerCase().trim();
            lista.querySelectorAll('li[data-equipos]').forEach(card => {
                card.style.display = (card.dataset.equipos ?? '').includes(term) ? '' : 'none';
            });
        });
    }
});
