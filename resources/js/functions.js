import './views/estadios.js';
import './views/equipos.js';
import './views/grupos.js';
import './views/calendario.js';
import './views/proximos-partidos.js';
import './views/mis-predicciones.js';

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
    
    // const tablaParticipantes = document.getElementById('ranking-table');

    // if (tablaParticipantes) {

    //     try {
    
    //         let participantes = await obtenerUsuariosParticipantes();

    //         if (participantes && participantes.length) {
    //             pintarParticipantes(participantes);   
    //         }
    
    
    //     } catch (error) {
    
    //         console.error(error);
    
    //     }


    // }


    toggleLoader()

});

/**************QUINIELA SELECT */

// const pintarPartidosJornadaQuiniela = (equipos) => {

//     let espacioQuiniela = document.querySelector(`#partidos-jornada-quiniela`);

//     let partidos = [];

//     let partidosAPintar = [];

//     const opcionesFecha = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' };



//     for (let index = 0; index < equipos.length; index++) {

//         partidos.push(equipos.slice(index, index + 2));

//         index++;

//     }



//     partidos.forEach(element => {

//         if (element[0].partido_id == element[1].partido_id) {

//             let row = `<li class="flex justify-around lg:py-2 pb-28 my-4 xl:my-2 border-b border-gray-400 items-center ${element[0].estado == 0 ? 'partido-modulo-pronosticos' : '' } partido-${element[0].partido_id}">

//             <input type="number" value="${element[0].partido_id}" hidden class="hidden partido-jornada-quiniela" disabled>

//             <div class="w-1/2 xl:w-1/3 flex items-center justify-between px-1">

//                 <div class="flex flex-col justify-center items-center xl:flex-row w-1/3 md:w-auto ml-2">

//                     <img src="${element[0].imagen}" alt="SELECCION" class="h-10 w-14 mx-4 border rounded-md shadow-md">

//                     <p class="font-semibold text-xs xs:text-md lg:text-xl m-4">${element[0].nombre}</p>

//                 </div>

//                 <div class="flex flex-col justify-center items-center w-auto">

//                     <div>

//                         <button class="" onclick="increaseBookmar(this)"><i><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-up-circle-fill text-rose-600 hover:text-rose-900" viewBox="0 0 16 16">

//                             <path d="M16 8A8 8 0 1 0 0 8a8 8 0 0 0 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/>

//                           </svg></i>

//                         </button>

//                     </div>

//                     <div class="my-2">

//                         <input type="number" name="" min="0" max="10" value="0" class="marcador-equipo-1 marcador-equipo bg-gray-50 border border-gray-100 text-gray-900 text-center lg:text-right text-lg rounded-md focus:ring-blue-500 focus:border-blue-500 block w-8 md:w-14 p-2">

//                     </div>

//                     <div>

//                         <button class="" onclick="decreaseBookmar(this)"><i>

//                             <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-down-circle-fill text-rose-600 hover:text-rose-900" viewBox="0 0 16 16">

//                                 <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>

//                             </svg></i> 

//                         </button>

//                     </div>

//                 </div>

//             </div>

//             <div class="w-full xl:w-1/3 flex flex-col justify-center items-center mt-56 lg:my-0 absolute lg:relative">

//                 ${partidoJugado(element[0].fecha_partido,element[0].estado)}

//             </div>

//             <div class="w-1/2 xl:w-1/3 flex items-center justify-between px-1">

//                 <div class="flex flex-col justify-center items-center w-auto">

//                     <div>

//                         <button class="" onclick="increaseBookmar(this)"><i><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-up-circle-fill text-rose-600 hover:text-rose-900" viewBox="0 0 16 16">

//                             <path d="M16 8A8 8 0 1 0 0 8a8 8 0 0 0 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/>

//                           </svg></i>

//                         </button>

//                     </div>

//                     <div class="my-2">

//                         <input type="number" name="" min="0" max="10" value="0" class="marcador-equipo-2 marcador-equipo bg-gray-50 border border-gray-100 text-gray-900 text-center lg:text-right text-lg rounded-md focus:ring-blue-500 focus:border-blue-500 block w-8 md:w-14 p-2">

//                     </div>

//                     <div>

//                         <button class="" onclick="decreaseBookmar(this)"><i>

//                             <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-down-circle-fill text-rose-600 hover:text-rose-900" viewBox="0 0 16 16">

//                                 <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>

//                             </svg></i>

//                         </button>

//                     </div>

//                 </div>

//                 <div class="flex flex-col-reverse justify-center items-center xl:flex-row w-1/3 md:w-auto mr-2">

//                     <p class="font-semibold text-xs xs:text-md lg:text-xl m-4">${element[1].nombre}</p>

//                     <img src="${element[1].imagen}" alt="SELECCION" class="h-10 w-14 mx-4 border rounded-md shadow-md">

//                 </div>

//             </div>

//         </li>`;

//             partidosAPintar.push(row);

//         } else {


//         }

//     });



//     espacioQuiniela.innerHTML = partidosAPintar;

// }



// const partidoJugado = (fecha_partido,estado) => {

//     let returnData = ``;

//     if(estado == 0){

//         const opcionesFecha = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' };

//         returnData = `<i class="resultIcon">

                    

//         </i>

//         <p class="text-lg text-center">Fecha de encuentro</p>

//         <p class="text-lg text-center font-semibold">${new Date(fecha_partido.replace(/-/g, "/")).toLocaleDateString('es-ES', opcionesFecha)}</p>

//         <p class="text-md text-center font-semibold">${new Date(fecha_partido.replace(/-/g, "/")).toLocaleTimeString("es-GT", { hour12: true })}</p>`;

//     }else{

//         returnData = `<div class="resultadoPartido flex justify-between items-center text-3xl font-bold"></div><div class="puntosGenerados font-semibold text-center"></div>`;

//     }



//     return returnData;

// }


// async function obtenerUsuariosParticipantes() {

//     return await axios.get(`/obtener-tabla-participantes`);

// }

const pintarParticipantes = (usuarios) => {

    let tablaParticipantes = document.querySelector('#body-participantes-quiniela');
    
    const filas = usuarios.map((element, index) => {
        
        // const opcionesFecha = { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' };

        const position = index + 1;

        let positionText = '';
        let positionStyle = '';
        
        switch(position) {
            case 1:
                positionText = '1°. <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21v-2h4v-3.1q-1.225-.275-2.187-1.037T7.4 12.95q-1.875-.225-3.137-1.637T3 8V7q0-.825.588-1.412T5 5h2V3h10v2h2q.825 0 1.413.588T21 7v1q0 1.9-1.263 3.313T16.6 12.95q-.45 1.15-1.412 1.913T13 15.9V19h4v2zm0-10.2V7H5v1q0 .95.55 1.713T7 10.8m10 0q.9-.325 1.45-1.088T19 8V7h-2z"/></svg>';
                positionStyle = 'color: #EFBF04';
                break;
            case 2:
                positionText = '2°. <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21v-2h4v-3.1q-1.225-.275-2.187-1.037T7.4 12.95q-1.875-.225-3.137-1.637T3 8V7q0-.825.588-1.412T5 5h2V3h10v2h2q.825 0 1.413.588T21 7v1q0 1.9-1.263 3.313T16.6 12.95q-.45 1.15-1.412 1.913T13 15.9V19h4v2zm0-10.2V7H5v1q0 .95.55 1.713T7 10.8m10 0q.9-.325 1.45-1.088T19 8V7h-2z"/></svg>';
                positionStyle = 'color: #C4C4C4';
                break;
            case 3:
                positionText = '3°. <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21v-2h4v-3.1q-1.225-.275-2.187-1.037T7.4 12.95q-1.875-.225-3.137-1.637T3 8V7q0-.825.588-1.412T5 5h2V3h10v2h2q.825 0 1.413.588T21 7v1q0 1.9-1.263 3.313T16.6 12.95q-.45 1.15-1.412 1.913T13 15.9V19h4v2zm0-10.2V7H5v1q0 .95.55 1.713T7 10.8m10 0q.9-.325 1.45-1.088T19 8V7h-2z"/></svg>';
                positionStyle = 'color: #CE8946';
                break;
            default:
                positionText = `${position}°.`;
                break;
        }

        let row = `<tr class="border-b border-zinc-400">

        <th scope="row" class="py-4 px-6 font-bold text-lg whitespace-nowrap">

            <span style="${positionStyle}" class="flex gap-2 items-center">${positionText}</span>

        </th>

        <td class="py-4 px-6">

            ${element.nombres}

        </td>

        <td class="py-4 px-6">

            ${element.apellidos}

        </td>
        <td class="py-4 px-6">

            ${element.numero_documento}

        </td>
        <td class="py-4 px-6">

            ${element.email}

        </td>
        <td class="py-4 px-6">

            ${element.telefono}

        </td>

        <td class="py-4 px-6">

            ${element.puntos}

        </td>


        </tr>`;

        // <td class="py-4 px-6">

        //     ${new Date(element.created_at).toLocaleDateString('es-GT', opcionesFecha)}

        // </td>

    });

    tablaParticipantes.innerHTML = filas.join(' ');

}