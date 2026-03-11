<?php

use App\Http\Controllers\EstadioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PremioController;
use App\Http\Controllers\ResultadoPartidoController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\JornadaController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!

*/

/****** RUTAS GET PARA OBTENER VISTAS DE MODULOS */

Route::middleware(['auth'])->as('web.')->group(function() {

    // Redirección por defecto
    
    Route::get('/', function () {
        return redirect()->route('web.inicio');
    });

    // Inicio

    Route::prefix('inicio')->group(function() {
        Route::controller(JornadaController::class)->group(function() {
            Route::get('proximos-partidos', 'proximosPartidosWeb')->name('inicio');
        });
    });

    Route::controller(HomeController::class)->group(function() {
        Route::get('inicio', 'index');
    });

    // Selecciones

    Route::controller(EquipoController::class)->prefix('selecciones')->as('selecciones.')->group(function() {
        Route::get('', 'indexWeb')->name('index');
    });

    // Grupos

    Route::controller(GrupoController::class)->prefix('grupos')->as('grupos.')->group(function() {
        Route::get('/{grupo_id}/equipos', 'getEquiposWeb')->name('equipos');
        Route::get('/{grupo_id}/jornadas', 'getJornadasWeb')->name('jornadas');
        Route::get('', 'indexWeb')->name('index');
    });

    // Jornadas

    Route::controller(JornadaController::class)->prefix('jornadas')->group(function() {
        Route::get('', 'jornadasWeb')->name('jornadas');

        Route::post('/partidos-grupo', 'partidosGrupo');
        Route::get('/partidos-jornada/{jornada}', 'partidosJornada');
    });

    // Estadios

    Route::controller(EstadioController::class)->group(function() {
        Route::get('/ver-sedes', 'verEstadios')->name('ver-sedes');
    });

    // Partidos y resultados

    Route::controller(ResultadoPartidoController::class)->group(function() {
        Route::get('/ver-quiniela/{jornada?}/{message?}', 'verQuiniela')->name('ver-quiniela');
        Route::post('/guardar-predicciones-form', 'guardarPrediccionesForm')->name('guardar-predicciones-form');

        // Route::get('/ver-tabla-resultados', 'verTablaResultados')->name('ver-tabla-resultados');
        // Route::get('/obtener-tabla-participantes', 'obtenerParticipantes');
        // Route::post('/guardar-predicciones/', 'guardarPredicciones');
        // Route::post('/obtener-predicciones/', 'obtenerPrediccionesGuardadas');
    });

    Route::controller(UserController::class)->as('users')->group(function() {
        Route::get('ranking', 'indexWeb')->name('.ranking');
    });

    // Premios

    Route::controller(PremioController::class)->group(function() {
        Route::get('/ver-tabla-premios', 'verTablaPremios')->name('ver-tabla-premios');
    });

    // Perfil

    Route::get('/perfil', function () {
        return view('modulos.perfil');
    })->name('perfil');
    

    // Rutas para super-admin

    Route::controller(ResultadoPartidoController::class)->group(function() {

        Route::get('/actualizar-puntos-usuarios', 'actualizarPuntosParticipantesALL');

    });

});

Route::middleware(['guest'])->group(function() {

    // Participantes inscritos

    Route::controller(UserController::class)->group(function() {
        Route::get('/participantes', 'verParticipantes')->name('ver-participantes');
    });

});

// Los metodos post se cambiaron a put porque el servidor donde se alojara la aplicacion no permite post


require __DIR__.'/auth.php';
