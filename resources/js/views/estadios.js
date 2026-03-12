import { initEstadioModal } from '../components/estadio-modal.js';

document.addEventListener('DOMContentLoaded', () => {

    initEstadioModal();

    // Filtro de búsqueda
    const buscarInput = document.getElementById('buscar-estadios');
    if (buscarInput) {
        buscarInput.addEventListener('input', function () {
            const term = this.value.toLowerCase().trim();
            document.querySelectorAll('.estadio-card').forEach(card => {
                card.style.display = card.dataset.nombre.toLowerCase().includes(term) ? '' : 'none';
            });
        });
    }

});
