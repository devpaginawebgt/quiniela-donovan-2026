import { initTeamModal } from '../components/team-modal.js';

document.addEventListener('DOMContentLoaded', () => {

    initTeamModal();

    // Filtro de búsqueda
    const buscarInput = document.getElementById('buscar-selecciones');
    if (buscarInput) {
        buscarInput.addEventListener('input', function () {
            const term = this.value.toLowerCase().trim();
            document.querySelectorAll('.team-card').forEach(card => {
                card.style.display = card.dataset.nombre.toLowerCase().includes(term) ? '' : 'none';
            });
        });
    }

});
