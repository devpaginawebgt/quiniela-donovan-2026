import { initResultCardToggle } from '../components/result-card.js';

initResultCardToggle();

document.addEventListener('DOMContentLoaded', () => {

    // Logica para cambiar de jornada

    const select = document.getElementById('select-mis-predicciones');
    if (!select) return;

    select.addEventListener('change', () => {
        document.getElementById('form-mis-predicciones').submit();
    });

    // Logica para filtrar los registros de resultados

    const buscar = document.getElementById('buscar-partidos');
    const lista  = document.getElementById('partidos-jornada-general');
    if (!buscar || !lista) return;

    buscar.addEventListener('input', function () {
        const term = this.value.toLowerCase().trim();
        lista.querySelectorAll('li[data-equipos]').forEach(card => {
            card.style.display = (card.dataset.equipos ?? '').includes(term) ? '' : 'none';
        });
    });
    
});
