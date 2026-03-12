document.addEventListener('DOMContentLoaded', () => {

    const modal = document.getElementById('modal-estadio');

    if (!modal) return;

    const panel       = document.getElementById('modal-estadio-panel');
    const modalImg    = document.getElementById('modal-estadio-img');
    const modalNombre = document.getElementById('modal-estadio-nombre');
    const modalDesc   = document.getElementById('modal-estadio-descripcion');
    const backdrop    = document.getElementById('modal-estadio-backdrop');
    const closeBtn    = document.getElementById('modal-estadio-close');

    const openModal = () => {
        modal.classList.remove('pointer-events-none');
        backdrop.classList.remove('opacity-0');
        panel.classList.remove('translate-y-full', 'opacity-0');
        document.body.style.overflow = 'hidden';
    };

    const closeModal = () => {
        backdrop.classList.add('opacity-0');
        panel.classList.add('translate-y-full', 'opacity-0');
        document.body.style.overflow = '';
        panel.addEventListener('transitionend', () => {
            modal.classList.add('pointer-events-none');
        }, { once: true });
    };

    // Abrir modal al hacer click en una card
    document.querySelectorAll('.estadio-card').forEach(card => {
        card.addEventListener('click', () => {
            modalNombre.textContent = card.dataset.nombre;
            modalImg.src            = card.dataset.imagen;
            modalImg.alt            = card.dataset.nombre;
            modalDesc.textContent   = card.querySelector('.estadio-descripcion').textContent.trim();
            openModal();
        });
    });

    backdrop.addEventListener('click', closeModal);
    closeBtn.addEventListener('click', closeModal);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('pointer-events-none')) closeModal();
    });

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
