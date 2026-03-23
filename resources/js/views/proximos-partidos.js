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
                .then(response => console.log(response.data))
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
});
