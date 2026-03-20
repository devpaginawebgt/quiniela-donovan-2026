/**
 * Inicializa el modal/drawer de Términos y Condiciones.
 * Los botones .btn-crear-cuenta abren el modal.
 * Al confirmar, se escribe la versión de T&C en el hidden input del form activo y se hace submit.
 */
export const initTermsModal = () => {

    const modal    = document.getElementById('modal-terms');
    if (!modal) return;

    const panel    = document.getElementById('modal-terms-panel');
    const backdrop = document.getElementById('modal-terms-backdrop');
    const checkbox = document.getElementById('terms-checkbox');
    const btnConfirm = document.getElementById('btn-confirmar-terms');
    const termsVersion = document.getElementById('terms-version-value')?.value || '';

    let activeForm = null;

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

    // Botones "Crear Cuenta" abren el modal
    document.querySelectorAll('.btn-crear-cuenta').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            activeForm = btn.closest('form');
            if (!activeForm.reportValidity()) return;
            openModal();
        });
    });

    // Checkbox habilita/deshabilita botón confirmar
    checkbox.addEventListener('change', () => {
        btnConfirm.disabled = !checkbox.checked;
    });

    // Confirmar: escribir versión en hidden input y submit
    btnConfirm.addEventListener('click', () => {
        if (!activeForm) return;

        const hiddenInput = activeForm.querySelector('input[name="accepted_terms_version"]');
        if (hiddenInput) {
            hiddenInput.value = termsVersion;
        }

        activeForm.submit();
    });

    // Cierre
    backdrop.addEventListener('click', closeModal);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('pointer-events-none')) closeModal();
    });

};
