/**
 * Inicializa los botones +/- de marcador. Utiliza event listeners.
 * Los botones deben tener la clase btn-marcador-increase o btn-marcador-decrease.
 */
export const initMarcadorButtons = () => {
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.btn-marcador-increase, .btn-marcador-decrease');
        if (!btn) return;

        const input = btn.parentElement.querySelector('.marcador-equipo');
        if (!input) return;

        if (btn.classList.contains('btn-marcador-increase')) {
            input.value++;
        } else {
            if (input.value > 0) input.value--;
        }
    });
};
