export const setButtonLoading = (btn, text = 'Procesando...') => {
    if (!btn || btn.dataset.loading === 'true') return;
    btn.dataset.loading = 'true';
    btn.disabled = true;
    btn.classList.add('opacity-70', 'cursor-not-allowed');
    btn.innerHTML = `
        <span class="icon-[material-symbols--progress-activity] w-6 h-6 animate-spin"></span>
        ${text}
    `;
};
