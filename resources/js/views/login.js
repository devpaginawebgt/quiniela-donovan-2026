import { setButtonLoading } from '../components/button-loading';

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form.formulario-auth');
    if (!form) return;

    form.addEventListener('submit', () => {
        setButtonLoading(form.querySelector('button[type="submit"]'), 'Ingresando...');
    });
});
