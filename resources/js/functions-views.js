
import './views/estadios.js';
import './views/calendario.js';
import './views/proximos-partidos.js';
import './views/mis-predicciones.js';

const toggleDetalles = (btn) => {
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
}

window.toggleDetalles = toggleDetalles;

const slideToggle = (id) => {
    const contenidoSeleccion = document.querySelector(`.container-${id}`);
    contenidoSeleccion.classList.toggle('block');
    contenidoSeleccion.classList.toggle('hidden');
}

window.slideToggle = slideToggle;

const increaseBookmar = (btn) => {
    let marcador = btn.parentElement.querySelector('.marcador-equipo');
    marcador.value++;
}

window.increaseBookmar = increaseBookmar;

const decreaseBookmar = (btn) => {
    let marcador = btn.parentElement.querySelector('.marcador-equipo');
    (marcador.value > 0 ? marcador.value-- : marcador = marcador);
}

window.decreaseBookmar = decreaseBookmar;

const guardarMarcadoresPartidos = async (user_id) => {
    let partidosAGuardar = [];
    let contenedoresPartidos = document.querySelectorAll(".partido-modulo-pronosticos");

    contenedoresPartidos.forEach(container => {
        let partido = {
            partido_id : container.querySelector('.partido-jornada-quiniela').value,
            marcador_equipo_1 : container.querySelector('.marcador-equipo-1').value,
            marcador_equipo_2 : container.querySelector('.marcador-equipo-2').value
        }

        partidosAGuardar.push(partido);
    });

    let responseSavePrediccions = await enviarPrediccionesPartidos(user_id,partidosAGuardar);
    if(responseSavePrediccions == "1OK"){
        savedAlert('Listo!','Se guardaron tus marcadores.','success');
    }else{
        if(responseSavePrediccions == "2OK"){
            savedAlert('Oh!','Algunos marcadores no fueron guardados, un partido iniciara pronto.','warning');
        }else{
            savedAlert('Oh!','Hubo un problema al guardar tus datos, intentalo mas tarde.','warning');
        }
    }
}

const pintarMarcadoresPartidos = async (partidosAMostrar) => {
    partidosAMostrar.forEach(partido => {
        let partidoContainer = document.querySelector(`.partido-${partido.partido_id}`);
        partidoContainer.querySelector('.marcador-equipo-1').value = partido.goles_equipo_1;
        partidoContainer.querySelector('.marcador-equipo-2').value = partido.goles_equipo_2;
    });
}

const savedAlert = (titulo, mensaje, icono, response) => {

    Swal.fire(
        {
            title: titulo,
            text: mensaje,
            icon: icono,
            showConfirmButton: false,
            showCancelButton: false,
            timer:1200
        }
    )
}