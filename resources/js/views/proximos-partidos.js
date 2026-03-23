import { initMarcadorButtons } from '../components/marcador.js';
import { showToastErrors } from '../components/toast-errors.js';

initMarcadorButtons();

document.addEventListener('DOMContentLoaded', () => {

    // Logica para cambiar de jornada 

    const select = document.getElementById('select-proximos-partidos');

    if (!select) return;

    select.addEventListener('change', () => {
        document.getElementById('form-proximos-partidos').submit();
    });

    // Logica para filtrar los registros de predicciones en la vista

    const buscar = document.getElementById('buscar-partidos');
    const lista  = document.getElementById('partidos-jornada-general');

    if (buscar && lista) {
        buscar.addEventListener('input', function () {
            const term = this.value.toLowerCase().trim();
            lista.querySelectorAll('li[data-equipos]').forEach(card => {
                card.style.display = (card.dataset.equipos ?? '').includes(term) ? '' : 'none';
            });
        });
    }

    // Logica para guardar predicciones via AJAX

    const formPredicciones = document.getElementById('formPredicionesWeb');

    if (formPredicciones) {
        
        const btnSubmit = formPredicciones.querySelector('button[type="submit"]');
        const inputsMarcador = formPredicciones.querySelectorAll('.marcador-equipo');

        function setFormDisabled(disabled) {
            if (btnSubmit) {
                btnSubmit.disabled = disabled;
                btnSubmit.classList.toggle('opacity-50', disabled);
                btnSubmit.classList.toggle('pointer-events-none', disabled);
            }

            inputsMarcador.forEach(input => {
                input.disabled = disabled;
                input.classList.toggle('opacity-50', disabled);
            });
        }

        formPredicciones.addEventListener('submit', function (e) {
            e.preventDefault();

            setFormDisabled(true);

            const partidoInputs = document.querySelectorAll('.partido-jornada-quiniela');
            const predicciones = [];

            partidoInputs.forEach(function (input) {
                const parsedId = parseInt(input.value);
                const idPartido = isNaN(parsedId) ? null : parsedId;

                const inputEquipo1 = document.querySelector(`[name="prediccion_equipo1_${input.value}"]`);
                const inputEquipo2 = document.querySelector(`[name="prediccion_equipo2_${input.value}"]`);

                const rawEquipo1 = inputEquipo1 ? parseInt(inputEquipo1.value) : NaN;
                const rawEquipo2 = inputEquipo2 ? parseInt(inputEquipo2.value) : NaN;

                const prediccionEquipoUno = isNaN(rawEquipo1) ? null : rawEquipo1;
                const prediccionEquipoDos = isNaN(rawEquipo2) ? null : rawEquipo2;

                if (idPartido !== null && prediccionEquipoUno !== null && prediccionEquipoDos !== null) {
                    predicciones.push({
                        idPartido,
                        prediccionEquipoUno,
                        prediccionEquipoDos,
                    });
                }
            });

            const url = formPredicciones.dataset.urlPredicciones;

            axios.post(url, { predicciones })
                .then(response => {
                    const data = response.data.data;
                    openModalResultado(data.prediccionesProcesadas, data.prediccionesRechazadas);
                })
                .catch(error => {
                    if (error.response?.status === 422) {
                        const errors = error.response.data.errors;
                        const messages = Object.values(errors).flat();
                        showToastErrors(messages);
                        return;
                    }

                    showToastErrors(['Ocurrió un error inesperado. Intenta de nuevo.']);
                })
                .finally(() => setFormDisabled(false));
        });
    }

    // Modal resultado de predicciones

    const modal = document.getElementById('modal-resultado-predicciones');
    const backdrop = document.getElementById('modal-resultado-backdrop');
    const panel = document.getElementById('modal-resultado-panel');
    const cardsContainer = document.getElementById('modal-resultado-cards');
    const btnClose = document.getElementById('modal-resultado-close');

    function createResultCard(prediccion, tipo) {
        const isAceptada = tipo === 'aceptada';
        const borderColor = 'border-secondary';
        const badgeBg = isAceptada ? 'bg-green-600' : 'bg-red-600';
        const badgeIcon = isAceptada
            ? '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" d="m9.55 18l-5.7-5.7l1.425-1.425L9.55 15.15l9.175-9.175L20.15 7.4z"/></svg>'
            : '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="currentColor" d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12z"/></svg>';
        const badgeText = isAceptada ? 'Aceptada' : 'Rechazada';
        const msgBg = 'bg-secondary text-dark';

        let brandHTML = '';
        if (prediccion.marca) {
            brandHTML = `
                <div class="flex rounded-t-3xl overflow-hidden">
                    <div class="bg-red-700/80 flex items-center py-2 px-3">
                        <span class="text-light text-sm font-medium whitespace-nowrap">Partido patrocinado por</span>
                    </div>
                    <div class="flex-1 flex items-center justify-center p-2 bg-green-700">
                        <img src="${prediccion.marca.image}" alt="${prediccion.marca.name}" class="w-full max-w-28 object-contain">
                    </div>
                </div>`;
        }

        return `
            <div class="bg-complementary-primary border ${borderColor} rounded-3xl flex flex-col overflow-hidden">
                ${brandHTML}
                <div class="flex flex-col p-5 gap-4">
                    <div class="flex justify-end">
                        <span class="flex items-center gap-1 ${badgeBg} text-white text-sm font-semibold px-3 py-1.5 rounded-full">
                            ${badgeIcon}
                            ${badgeText}
                        </span>
                    </div>

                    <div class="flex items-center justify-between gap-2">
                        <div class="flex flex-col items-center gap-2 flex-1">
                            <img src="${prediccion.equipoUno.imagen}" alt="${prediccion.equipoUno.nombre}" class="w-full max-w-20 aspect-6/4 object-cover rounded-xl shadow-md">
                            <p class="font-semibold text-sm text-center text-light leading-tight">${prediccion.equipoUno.nombre}</p>
                        </div>
                        <span class="font-bold text-2xl text-light shrink-0">VS</span>
                        <div class="flex flex-col items-center gap-2 flex-1">
                            <img src="${prediccion.equipoDos.imagen}" alt="${prediccion.equipoDos.nombre}" class="w-full max-w-20 aspect-6/4 object-cover rounded-xl shadow-md">
                            <p class="font-semibold text-sm text-center text-light leading-tight">${prediccion.equipoDos.nombre}</p>
                        </div>
                    </div>

                    <hr class="border-complementary-light/30">

                    <div class="${msgBg} rounded-xl p-4 text-center font-semibold text-sm">
                        ${prediccion.message}
                    </div>
                </div>
            </div>`;
    }

    function openModalResultado(procesadas, rechazadas) {
        cardsContainer.innerHTML = '';

        (procesadas || []).forEach(p => {
            cardsContainer.insertAdjacentHTML('beforeend', createResultCard(p, 'aceptada'));
        });

        (rechazadas || []).forEach(p => {
            cardsContainer.insertAdjacentHTML('beforeend', createResultCard(p, 'rechazada'));
        });

        document.body.classList.add('overflow-hidden');
        modal.style.display = '';
        modal.classList.remove('pointer-events-none');

        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            panel.classList.remove('opacity-0');
        });
    }

    function closeModalResultado() {
        backdrop.classList.add('opacity-0');
        panel.classList.add('opacity-0');

        setTimeout(() => {
            modal.style.display = 'none';
            modal.classList.add('pointer-events-none');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }

    if (btnClose) {
        btnClose.addEventListener('click', closeModalResultado);
    }

    if (backdrop) {
        backdrop.addEventListener('click', closeModalResultado);
    }
});
