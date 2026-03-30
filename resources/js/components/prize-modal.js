/**
 * Inicializa el modal/drawer de premios (prize-card).
 * Gestiona apertura, cierre, populate de datos y tecla Escape.
 */
export const initPrizeModal = () => {

    const modal = document.getElementById('modal-premio');

    if (!modal) return;

    const panel       = document.getElementById('modal-premio-panel');
    const modalImg    = document.getElementById('modal-premio-img');
    const modalNombre = document.getElementById('modal-premio-nombre');
    const modalDesc   = document.getElementById('modal-premio-descripcion');
    const backdrop    = document.getElementById('modal-premio-backdrop');
    const closeBtn    = document.getElementById('modal-premio-close');

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

    document.querySelectorAll('.prize-card').forEach(card => {
        card.addEventListener('click', () => {
            modalNombre.textContent = card.dataset.nombre;
            modalImg.src            = card.dataset.imagen;
            modalImg.alt            = card.dataset.nombre;
            modalDesc.textContent   = card.querySelector('.prize-card-descripcion').textContent.trim();
            openModal();
        });
    });

    backdrop.addEventListener('click', closeModal);
    closeBtn.addEventListener('click', closeModal);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('pointer-events-none')) closeModal();
    });

};
