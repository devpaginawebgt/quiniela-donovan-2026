<?php

use App\Http\Controllers\BracketController;
use App\Http\Controllers\EstadioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PremioController;
use App\Http\Controllers\ResultadoPartidoController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\JornadaController;
use App\Http\Controllers\QuizController;
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

    // Inicio

    Route::prefix('inicio')->as('inicio.')->group(function() {

        Route::controller(ResultadoPartidoController::class)->group(function() {
            Route::get('proximos-partidos', 'proximosPartidosWeb')->name('proximos-partidos');
            Route::get('mis-predicciones', 'misPrediccionesWeb')->name('mis-predicciones');
            Route::post('predicciones', 'savePrediccionesWeb')->name('save-predicciones');
        });

        Route::controller(JornadaController::class)->group(function() {
            Route::get('calendario', 'calendarioWeb')->name('calendario');
        });

        Route::controller(EstadioController::class)->group(function() {
            Route::get('estadios', 'estadiosWeb')->name('estadios');
        });

        Route::controller(GrupoController::class)->group(function() {            
            Route::get('grupos', 'gruposWeb')->name('grupos');
        });

        Route::controller(EquipoController::class)->group(function() {
            Route::get('equipos', 'equiposWeb')->name('equipos');
        });

        Route::get('', function () {
            return redirect()->route('web.inicio.proximos-partidos');
        });

        Route::controller(QuizController::class)->group(function() {

            Route::get('trivia', 'indexWeb')->name('trivia');
            Route::post('trivia', 'store')->name('trivias.store');
            Route::get('trivia-puntos', 'lastAttemptWeb')->name('trivia-puntos');
        });
    });

    // Selecciones

    // Grupos

    Route::controller(GrupoController::class)->prefix('grupos')->as('grupos.')->group(function() {
        Route::get('/{grupo_id}/equipos', 'getEquiposWeb')->name('equipos');
        Route::get('/{grupo_id}/jornadas', 'getJornadasWeb')->name('jornadas');
    });

    // Jornadas

    Route::controller(JornadaController::class)->prefix('jornadas')->group(function() {
        // Route::get('', 'jornadasWeb')->name('jornadas');

        Route::post('/partidos-grupo', 'partidosGrupo');
        Route::get('/partidos-jornada/{jornada}', 'partidosJornada');
    });

    // Partidos y resultados

    Route::controller(ResultadoPartidoController::class)->group(function() {
        Route::post('/guardar-predicciones-form', 'guardarPrediccionesForm')->name('guardar-predicciones-form');
        // Route::get('/ver-quiniela/{jornada?}/{message?}', 'verQuiniela')->name('ver-quiniela');
        // Route::get('/ver-tabla-resultados', 'verTablaResultados')->name('ver-tabla-resultados');
        // Route::get('/obtener-tabla-participantes', 'obtenerParticipantes');
        // Route::post('/guardar-predicciones/', 'guardarPredicciones');
        // Route::post('/obtener-predicciones/', 'obtenerPrediccionesGuardadas');
    });

    Route::controller(UserController::class)->as('users')->group(function() {
        Route::get('ranking', 'indexWeb')->name('.ranking');
        Route::get('ranking/data', 'getRankingData')->name('.ranking.data');
        Route::get('/perfil', 'perfil')->name('.perfil');
    });

    // Premios

    Route::controller(PremioController::class)->group(function() {
        Route::get('/recompensas', 'recompensas')->name('recompensas');
    });

    // Rutas solo para admins
    Route::middleware('role:admin')->prefix('admin')->as('admin.')->group(function () {
        Route::get('/', fn () => view('modulos.admin.dashboard'))->name('dashboard');
    });

    Route::get('/', function () {
        return redirect()->route('web.inicio.proximos-partidos');
    });

});

// Route::middleware(['guest'])->group(function() {

//     // Participantes inscritos

//     Route::controller(UserController::class)->group(function() {
//         Route::get('/participantes', 'verParticipantes')->name('ver-participantes');
//     });

// });

// Los metodos post se cambiaron a put porque el servidor donde se alojara la aplicacion no permite post


// Embed (público, sin auth — para Flutter WebView)

Route::get('/embed/bracket', [BracketController::class, 'show'])->name('embed.bracket');


require __DIR__.'/auth.php';
