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
        
}
