/**
 * Inicializa el toggle de detalles para las result-card mediante event delegation.
 * Los botones deben tener la clase result-card-toggle.
 */
export const initResultCardToggle = () => {
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.result-card-toggle');
        if (!btn) return;

        const panel = btn.nextElementSibling;
        const icon  = btn.querySelector('svg');
        const open  = btn.getAttribute('aria-expanded') === 'true';

        if (open) {
            panel.style.maxHeight = panel.scrollHeight + 'px';
            requestAnimationFrame(() => { panel.style.maxHeight = '0px'; });
            btn.setAttribute('aria-expanded', 'false');
            icon.style.transform = 'rotate(0deg)';
        } else {
            panel.style.maxHeight = panel.scrollHeight + 'px';
            btn.setAttribute('aria-expanded', 'true');
            icon.style.transform = 'rotate(180deg)';
        }
    });
};
