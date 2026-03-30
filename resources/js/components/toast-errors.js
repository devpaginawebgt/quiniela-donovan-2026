const AUTO_DISMISS_MS = 5000;
const STAGGER_MS = 300;

function dismissToast(toast, container) {
    toast.style.animation = 'toast-fade-out 0.3s ease-in forwards';
    toast.addEventListener('animationend', () => {
        toast.remove();
        if (container.children.length === 0) {
            container.style.display = 'none';
        }
    }, { once: true });
}

function bindToasts(container) {
    const toasts = container.querySelectorAll('.toast-item');

    toasts.forEach((toast) => {
        const closeBtn = toast.querySelector('[data-toast-dismiss]');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => dismissToast(toast, container));
        }
    });

    toasts.forEach((toast, index) => {
        setTimeout(() => {
            if (toast.parentNode) {
                dismissToast(toast, container);
            }
        }, AUTO_DISMISS_MS + (index * STAGGER_MS));
    });
}

/**
 * Initializes toasts rendered server-side.
 */
export function initToastErrors() {
    const container = document.getElementById('toast-container');
    if (!container) return;

    bindToasts(container);
}

/**
 * Show toast error messages dynamically from JS.
 * @param {string[]} errors
 */
export function showToastErrors(errors) {
    const container = document.getElementById('toast-container');
    if (!container) return;

    container.innerHTML = '';

    errors.forEach((msg, index) => {
        container.insertAdjacentHTML('beforeend', `
            <div class="toast-item flex items-center w-full p-4 rounded-lg shadow-lg bg-red-900 border border-complementary-dark/30 text-light"
                 role="alert"
                 style="animation: toast-slide-in 0.4s ease-out both; animation-delay: ${index * 100}ms;">
                <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 rounded-lg bg-red-500/20 text-red-400">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                    </svg>
                </div>
                <div class="ms-3 text-sm font-normal">${msg}</div>
                <button type="button"
                        class="ms-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex items-center justify-center h-8 w-8 text-complementary-light hover:text-light hover:bg-complementary-dark/30"
                        data-toast-dismiss
                        aria-label="Cerrar">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        `);
    });

    container.style.display = 'flex';
    bindToasts(container);
}
