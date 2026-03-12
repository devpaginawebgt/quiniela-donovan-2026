/**
 * Inicializa el modal/drawer de selecciones (team-card).
 * Gestiona apertura, cierre, populate de datos y tecla Escape.
 */
export const initTeamModal = () => {

    const modal    = document.getElementById('modal-equipo');

    if (!modal) return;

    const panel       = document.getElementById('modal-equipo-panel');
    const modalImg    = document.getElementById('modal-equipo-img');
    const modalNombre = document.getElementById('modal-equipo-nombre');
    const modalDesc   = document.getElementById('modal-equipo-descripcion');
    const backdrop    = document.getElementById('modal-equipo-backdrop');
    const closeBtn    = document.getElementById('modal-equipo-close');

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

    document.querySelectorAll('.team-card').forEach(card => {
        card.addEventListener('click', () => {
            modalNombre.textContent = card.dataset.nombre;
            modalImg.src            = card.dataset.imagen;
            modalImg.alt            = card.dataset.nombre;
            modalDesc.textContent   = card.querySelector('.team-card-descripcion').textContent.trim();
            openModal();
        });
    });

    backdrop.addEventListener('click', closeModal);
    closeBtn.addEventListener('click', closeModal);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('pointer-events-none')) closeModal();
    });

};
