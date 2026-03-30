import { initPrizeModal } from '../components/prize-modal.js';

document.addEventListener('DOMContentLoaded', () => {

    initPrizeModal();

    // Filtro de búsqueda
    const buscarInput = document.getElementById('buscar-premios');
    if (buscarInput) {
        buscarInput.addEventListener('input', function () {
            const term = this.value.toLowerCase().trim();
            document.querySelectorAll('.prize-card').forEach(card => {
                card.style.display = card.dataset.nombre.toLowerCase().includes(term) ? '' : 'none';
            });
        });
    }

});
