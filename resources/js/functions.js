import './views/estadios.js';
import './views/equipos.js';
import './views/grupos.js';
import './views/calendario.js';
import './views/proximos-partidos.js';
import './views/mis-predicciones.js';
import './views/recompensas.js';
import './views/admin-report.js';

// Helpers

function toggleLoader() {
    const spinnerLoad = document.querySelector(".spinner-load");
    
    if (spinnerLoad) {
        spinnerLoad.classList.toggle('hidden');
    }
}

// Peticiones

async function getEquiposGrupo(grupo) {

    return await axios.get(`/grupos/${grupo}/equipos`);

}

async function getJornadasGrupo( grupo ) {

    return await axios.get(`/grupos/${grupo}/jornadas`);

}


async function verEquiposGrupo(idGrupo) {
    try {
        toggleLoader()

        // Obtenemos los equipos del grupo

        const respuetaEquipos = await getEquiposGrupo(idGrupo);
        const grupo = respuetaEquipos.data.data;

        // Validamos que tenga equipos

        if (!grupo?.equipos?.length) return;

        pintarEquiposGrupo(grupo.equipos);

        // Obtenemos las jornadas del grupo

        const jornadasRes = await getJornadasGrupo(idGrupo);
        const jornadas = jornadasRes.data.data;

        // Validamos que hayan jornadas

        if (!jornadas?.length) return;

        const primeraJornada = jornadas.find(j => j.value === 1);

        if (primeraJornada) pintarPartidosGrupo(primeraJornada);

        const segundaJornada = jornadas.find(j => j.value === 2);

        if (segundaJornada) pintarPartidosGrupo(segundaJornada);

        const terceraJornada = jornadas.find(j => j.value === 3);

        if (terceraJornada) pintarPartidosGrupo(terceraJornada);

        toggleLoader()

    } catch (err) {
        alert('Ocurrió un error al obtener los datos del grupo');
        console.error(err);
    }
}


const verPartidosJornadaQuiniela = async (jornada) => {

    let formu = document.querySelector('#verPartidosQuinielaSelect');

    formu.action += '/' + jornada;

    formu.submit();

}

// Renderizado

const pintarEquiposGrupo = (equipos) => {

    let tablaEquipos = document.querySelector('#body-equipos-grupo');

    const filas = equipos.map(equipo => {

        const pj = equipo.stats.find(stat => stat.name === 'PJ');
        const pg = equipo.stats.find(stat => stat.name === 'PG');
        const pe = equipo.stats.find(stat => stat.name === 'PE');
        const pp = equipo.stats.find(stat => stat.name === 'PP');
        const gf = equipo.stats.find(stat => stat.name === 'GF');
        const gc = equipo.stats.find(stat => stat.name === 'GC');

        return `
            <tr class="bg-[--complementary-primary-color] border-b border-zinc-400 text-[--light-color]">
                <th scope="row" class="py-4 px-6 font-medium whitespace-nowrap flex items-center justify-between w-full">
                    <img src="${equipo.image}" alt="SELECCION" class="h-10 w-14 object-cover mx-4 rounded-md shadow-md">
                    ${equipo.name}
                </th>
                <td class="py-4 px-6">${pj.value}</td>
                <td class="py-4 px-6">${pg.value}</td>
                <td class="py-4 px-6">${pe.value}</td>
                <td class="py-4 px-6">${pp.value}</td>
                <td class="py-4 px-6">${gf.value}</td>
                <td class="py-4 px-6">${gc.value}</td>
                <td class="py-4 px-6">${equipo.puntos}</td>
            </tr>
        `;
    });

    tablaEquipos.innerHTML = filas.join(' ');

}

const pintarPartidosGrupo = (jornada) => {

    const espacioJornada = document.querySelector(`#partidos-jornada-${jornada.value}`);

    const partidos = jornada.partidos;

    const filas = partidos.map((partido) => {
            
        const opcionesFecha = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const fechaPartido = new Date(partido.fechaPartido).toLocaleDateString('es-GT', opcionesFecha);
        const horaPartido = new Date(partido.fechaPartido).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });

        return `<li class="flex justify-around py-6 lg:py-4 border-b border-zinc-400 items-center mb-4">

            <div class="w-1/2 flex-col lg:flex-row xl:w-1/4 flex items-center justify-between">

                <img src="${partido.equipoUno.imagen}" alt="SELECCION" class="h-10 w-14 object-cover mx-4 rounded-md shadow-md">

                <p class="font-semibold">${partido.equipoUno.nombre}</p>

            </div>

            <div class="w-full xl:w-1/3 absolute lg:relative">

                <p class="text-center">${fechaPartido}</p>

                <p class="text-center">${horaPartido}</p>

            </div>

            <div class="w-1/2 flex-col lg:flex-row xl:w-1/4 flex items-center justify-between">

                <img src="${partido.equipoDos.imagen}" alt="SELECCION" class="h-10 w-14 object-cover mx-4 rounded-md shadow-md">

                <p class="font-semibold">${partido.equipoDos.nombre}</p>

            </div>

        </li>`;

    });

    espacioJornada.innerHTML = filas.join(' ');

}


document.addEventListener('DOMContentLoaded', async () => {

    // Select de grupos

    const inputGrupo = document.getElementById('grupos');

    if (inputGrupo) {

        inputGrupo.addEventListener('change', function(e) {

            const idGrupo = inputGrupo.value;

            if (!idGrupo) return;

            verEquiposGrupo(idGrupo);

        })

    }

    const inputQuiniela = document.getElementById('quiniela');

    if (inputQuiniela) {

        inputQuiniela.addEventListener('change', function(e) {

            const idJornadaQuiniela = inputQuiniela.value;

            if (!idJornadaQuiniela) return;

            verPartidosJornadaQuiniela(idJornadaQuiniela);

        })

    }
    


    toggleLoader()

});