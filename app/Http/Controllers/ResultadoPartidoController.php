<?php

namespace App\Http\Controllers;

use App\Http\Requests\Prediccion\PrediccionRequest;
use App\Http\Resources\Prediccion\PrediccionResource;
use App\Http\Resources\Prediccion\PrediccionSolicitudResource;
use App\Http\Resources\Resultado\ResultadoResource;
use App\Http\Services\ModuleService;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\PartidoService;
use App\Http\Services\PrediccionService;
use App\Http\Services\UserService;
use App\Traits\ApiResponse;

class ResultadoPartidoController extends Controller
{
    use ApiResponse;

    // Inyección de servicios

    public function __construct(
        private readonly UserService $userService,
        private readonly ModuleService $moduleService,
        private readonly PartidoService $partidoService,
        private readonly PrediccionService $prediccionService
    ) {}

    // Respuestas API

    public function getPredicciones(Request $request, string $get_jornada)
    {
        // Validar que la jornada exista

        $id_jornada = (int)$get_jornada;

        if ( empty($id_jornada) ) {

            return $this->errorResponse('No se encontró la jornada', 422);

        }

        // Validar que la jornada exista

        $jornada = $this->partidoService->getJornada($id_jornada);

        if ( empty($jornada) ) {

            return $this->errorResponse('No se encontró la jornada', 422);

        }

        // Actualizar información general

        $user_id = $request->user()->id;

        $this->actualizacionDataGeneral($user_id);

        // Obtener los partidos de jornada

        $predicciones = $this->prediccionService->getPrediccionesJornada($id_jornada, $user_id);

        $predicciones = PrediccionResource::collection($predicciones);

        return $this->successResponse($predicciones);

    }

    public function savePredicciones(PrediccionRequest $request)
    {
        // Actualizar información general

        $user_id = $request->user()->id;

        $this->actualizacionDataGeneral($user_id);

        // Validar predicciones

        $predicciones_nuevas = collect($request->validated()['predicciones']);

        $id_partidos = $predicciones_nuevas->map(function($prediccion) {
            return $prediccion['id_partido'];
        })->toArray();

        // Obtener los partidos disponibles a predecir

        $predicciones_usuario = $this->prediccionService->getPrediccionesById($id_partidos, $user_id);  

        $validacion_predicciones = $this->prediccionService->validatePrediccionesUsuario($predicciones_nuevas, $predicciones_usuario);

        $predicciones_rechazadas = PrediccionSolicitudResource::collection($validacion_predicciones['rechazadas']);

        $predicciones_permitidas = $validacion_predicciones['permitidas'];

        if ( $predicciones_permitidas->isEmpty() ) {

            return $this->successResponse([
                'prediccionesRechazadas' => $predicciones_rechazadas,
                'prediccionesProcesadas' => []
            ]);

        }

        $ids_permitidos = $predicciones_permitidas->pluck('partido_id')->toArray();

        $predicciones_a_guardar = $predicciones_nuevas->filter(function ($prediccion) use ($ids_permitidos) {
            return in_array($prediccion['id_partido'], $ids_permitidos);
        });

        $predicciones_guardadas = $this->prediccionService->savePredicciones($predicciones_a_guardar, $predicciones_permitidas, $user_id);

        $predicciones_guardadas = PrediccionSolicitudResource::collection($predicciones_guardadas);

        return $this->successResponse([
            'prediccionesRechazadas' => $predicciones_rechazadas,
            'prediccionesProcesadas' => $predicciones_guardadas
        ]);

    }

    public function getResultados(Request $request, string $get_jornada)
    {
        // Validar que la jornada exista

        $id_jornada = (int)$get_jornada;

        if ( empty($id_jornada) ) {

            return $this->errorResponse('No se encontró la jornada', 422);

        }

        // Validar que la jornada exista

        $jornada = $this->partidoService->getJornada($id_jornada);

        if ( empty($jornada) ) {

            return $this->errorResponse('No se encontró la jornada', 422);

        }

        // Actualizar información general

        $user_id = $request->user()->id;

        $this->actualizacionDataGeneral($user_id);

        // Obtener los partidos de jornada

        $resultados = $this->prediccionService->getResultados($id_jornada, $user_id);

        $resultados = ResultadoResource::collection($resultados);

        return $this->successResponse($resultados);

    }

    public function actualizacionDataGeneral(int $user_id)
    {

        // Actualizar los estados de los partidos cuya hora ya pasó

        $this->partidoService->actualizarPartidosPasados();
        
        // Actualizar los puntos de los equipos cuyo estado partido no es 1 (Actualizado)

        $this->partidoService->actualizarPuntosEquipos();

        // Actualizar puntos de usuario

        $this->prediccionService->actualizarPuntosParticipante($user_id);

    }

    // Continua lógica de la web

    public function proximosPartidosWeb(Request $request)
    {
        $user = Auth::user();

        $this->actualizacionDataGeneral($user->id);

        // Banners

        $banners = $this->moduleService->getBanners(7);

        // User Info
        
        $user = $this->userService->getUserRank($user);

        $user = $this->userService->getUserPredictionsCount($user);

        // Jornadas

        $jornadas = $this->partidoService->getJornadas();

        $jornada_activa = $jornadas->firstWhere('is_current', true);

        $jornada_filtrada = (int)$request->get('jornada') ?: $jornada_activa->id;

        // Partidos con predicciones del usuario

        $partidosJornada = $this->prediccionService->getPrediccionesJornada($jornada_filtrada, $user->id);

        return view('modulos.proximos-partidos', [
            'jornadas'        => $jornadas,
            'banners'         => $banners,
            'user'            => $user,
            'jornada_activa'  => $jornada_filtrada,
            'partidosJornada' => $partidosJornada,
        ]);
    }

    public function misPrediccionesWeb(Request $request)
    {
        $user = Auth::user();

        $this->actualizacionDataGeneral($user->id);

        // Banners

        $banners = $this->moduleService->getBanners(8);        

        // User Info
        
        $user = $this->userService->getUserRank($user);

        $user = $this->userService->getUserPredictionsCount($user);

        // Jornadas

        $jornadas = $this->partidoService->getJornadas();

        $jornada_activa = $jornadas->firstWhere('is_current', true);

        $jornada_filtrada = (int)$request->get('jornada') ?: $jornada_activa->id;

        // Partidos con predicciones del usuario

        $resultados = $this->prediccionService->getResultados($jornada_filtrada, $user->id);

        return view('modulos.mis-predicciones', [
            'jornadas'        => $jornadas,
            'banners'         => $banners,
            'user'            => $user,
            'jornada_activa'  => $jornada_filtrada,
            'resultados'      => $resultados,
        ]);
    }

    public function savePrediccionesWeb(PrediccionRequest $request)
    {
        // Actualizar información general

        $user = Auth::user();

        $user_id = $user->id;

        $this->actualizacionDataGeneral($user_id);

        // Validar predicciones

        $predicciones_nuevas = collect($request->validated()['predicciones']);

        $id_partidos = $predicciones_nuevas->map(function($prediccion) {
            return $prediccion['id_partido'];
        })->toArray();

        // Obtener los partidos disponibles a predecir

        $predicciones_usuario = $this->prediccionService->getPrediccionesById($id_partidos, $user_id);  

        $validacion_predicciones = $this->prediccionService->validatePrediccionesUsuario($predicciones_nuevas, $predicciones_usuario);

        $predicciones_rechazadas = PrediccionSolicitudResource::collection($validacion_predicciones['rechazadas']);

        $predicciones_permitidas = $validacion_predicciones['permitidas'];

        if ( $predicciones_permitidas->isEmpty() ) {

            return $this->successResponse([
                'prediccionesRechazadas' => $predicciones_rechazadas,
                'prediccionesProcesadas' => []
            ]);

        }

        $ids_permitidos = $predicciones_permitidas->pluck('partido_id')->toArray();

        $predicciones_a_guardar = $predicciones_nuevas->filter(function ($prediccion) use ($ids_permitidos) {
            return in_array($prediccion['id_partido'], $ids_permitidos);
        });

        $predicciones_guardadas = $this->prediccionService->savePredicciones($predicciones_a_guardar, $predicciones_permitidas, $user_id);

        $predicciones_guardadas = PrediccionSolicitudResource::collection($predicciones_guardadas);

        return $this->successResponse([
            'prediccionesRechazadas' => $predicciones_rechazadas,
            'prediccionesProcesadas' => $predicciones_guardadas
        ]);

    }


    // public function verQuiniela($jornada = null, $message = '0OK')
    // {
    //     $jornada = (int)$jornada;

    //     // Actualizar información general

    //     $user_id = Auth::user()->id;

    //     $this->actualizacionDataGeneral($user_id);

    //     // Obtenemos la información de la jornada a obtener

    //     $jornadas = $this->partidoService->getJornadas();

    //     $jornada_activa = $jornadas->firstWhere(function($jornada) {
    //         return $jornada->is_current === true;
    //     });

    //     $jornada_filtrada = empty($jornada) ? $jornada_activa->id : $jornada;

    //     // Obtener información de las predicciones realizadas por el usuario
        
    //     $partidosJornada = $this->prediccionService->getResultadosWeb($jornada_filtrada, $user_id);

    //     return view('modulos.quiniela', [
    //         'jornadas' => $jornadas,
    //         'partidosJornada' => $partidosJornada, 
    //         'jornada_activa' => $jornada_filtrada,
    //         'message' => $message ?? '', 
    //     ]);

    // }
    
    // public function guardarPrediccionesForm(Request $request)
    // {
    //     try {

    //         $count_error = 0;
    //         $message = "";
    //         $fecha_actual = new DateTime('now');

    //         foreach ($request->partidos as $partido_id) {

    //             $prediccion_equipo_1 = $request['prediccion_equipo1_' . $partido_id];
    //             $prediccion_equipo_2 = $request['prediccion_equipo2_' . $partido_id];

    //             if ($prediccion_equipo_1 === null || $prediccion_equipo_2 === null) {
    //                 continue;
    //             }

    //             $fecha_db = DB::select("select fecha_partido,estado FROM partidos WHERE id=" . $partido_id);
    //             $fecha_partido = new DateTime($fecha_db[0]->fecha_partido);
    //             $diff = $fecha_actual->diff($fecha_partido);
    //             $diferencia_minutos = (($diff->days * 1440 + $diff->h * 60) + $diff->i);
                
    //             if($diff->format('%R') == "+"){

    //                 if ($diferencia_minutos < 10) {
    //                     $count_error++;
    //                 } else {
    //                     DB::table('preccions')->updateOrInsert(
    //                         [
    //                             'user_id' => Auth::user()->id,
    //                             'partido_id' => $partido_id
    //                         ],
    //                         [
    //                             'goles_equipo_1' => $request['prediccion_equipo1_' . $partido_id],
    //                             'goles_equipo_2' => $request['prediccion_equipo2_' . $partido_id]
    //                         ]
    //                     );
    //                 }
    //             }else{
    //                 $count_error++;
    //             }
    //         }

    //         if ($count_error == 0) {
    //             $flash_type = 'success';
    //             $flash_msg  = 'Se guardaron tus predicciones correctamente.';
    //         } else {
    //             $flash_type = 'warning';
    //             $flash_msg  = 'Algunos pronósticos no se guardaron porque el partido ya está por iniciar.';
    //         }
    //     } catch (\Throwable $th) {
    //         $flash_type = 'error';
    //         $flash_msg  = 'Hubo un problema al guardar tus datos, inténtalo más tarde.';
    //     }

    //     return redirect()->route('web.inicio.proximos-partidos', ['jornada' => $request->jornada])
    //         ->with($flash_type, $flash_msg);
    // }

    // // Lógica de API

    // public function guardarPredicciones(Request $request)
    // {
    //     try {
    //         $count_error=0;
    //         $message = "";
    //         $fecha_actual = new DateTime('now');

    //         foreach ($request->partidos as $partido) {
    //             $fecha_db = DB::select("select fecha_partido FROM partidos WHERE id=" . $partido['partido_id']);
    //             $fecha_partido = new DateTime($fecha_db[0]->fecha_partido);
    //             $diff = $fecha_actual->diff($fecha_partido);
    //             $diferencia_minutos = (($diff->days * 1440 + $diff->h * 60) + $diff->i);

    //             if ( $diferencia_minutos < 10) {
    //                 $count_error++;
    //             } else {
    //                 DB::table('preccions')->where('status', "=", 0)
    //                     ->updateOrInsert(
    //                         [
    //                             'user_id' => $request->user_id,
    //                             'partido_id' => $partido['partido_id']
    //                         ],
    //                         [
    //                             'goles_equipo_1' => $partido['marcador_equipo_1'],
    //                             'goles_equipo_2' => $partido['marcador_equipo_2']
    //                         ]
    //                     );
    //             }
    //         }

    //         if($count_error == 0){
    //             $message = "1OK";
    //         }else{
    //             $message = "2OK";
    //         }
    //     } catch (\Throwable $th) {
    //         $message = $th;
    //     }

    //     return json_encode($message);
    // }

    // public function obtenerPrediccionesGuardadas(Request $request)
    // {

    //     $prediccionesPartidos = DB::select(
    //         "SELECT 
    //             p.goles_equipo_1,
    //             p.goles_equipo_2,
    //             p.partido_id,
    //             par.jornada,
    //             par.estado
    //         FROM 
    //             preccions p
    //         INNER JOIN 
    //             partidos par on p.partido_id = par.id 
    //         WHERE 
    //             par.jornada = $request->jornada 
    //         AND 
    //             p.user_id = $request->user_id"
    //     );

    //     return $prediccionesPartidos;

    // }

    // public function obtenerParticipantes($user_id)
    // {

    //     $pais = DB::select(
    //         "SELECT 
    //             pais_id 
    //         FROM 
    //             users 
    //         WHERE id = {$user_id}"
    //     );

    //     $id_pais = $pais[0]->pais_id;
        
    //     $participantes = DB::select(
    //         "SELECT 
    //             u.id,
    //             u.nombres,
    //             u.apellidos,
    //             u.puntos,
    //             u.email,
    //             u.telefono,
    //             u.numero_documento,
    //             c.estado
    //         FROM 
    //             users u
    //         INNER JOIN 
    //             codigos c on u.codigo_id = c.id 
    //         WHERE 
    //             c.estado != 0 
    //         AND 
    //             u.pais_id = {$id_pais} 
    //         AND
    //             u.puntos > 0
    //         ORDER BY 
    //             u.puntos DESC"
    //     );
        
    //     return json_encode($participantes);
    // }
    
    public function actualizarPuntosParticipantesALL()
    {
        
        $users = DB::select(
            "SELECT 
                id 
            FROM 
                users"
        );
        
        foreach ($users as $user) {
            $this->prediccionService->actualizarPuntosParticipante($user->id);
        }

        return "10OK";
    }
        
}
