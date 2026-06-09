<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatchScoreRequest\StoreMatchScoreRequestRequest;
use App\Http\Services\MatchScoreService;
use App\Models\MatchScoreRequest;
use App\Models\Partido;

class MatchScoreRequestController extends Controller
{
    public function index()
    {
        $requests = MatchScoreRequest::with([
                'partido.jornada:id,name',
                'partido.equipos.equipoUno:id,nombre',
                'partido.equipos.equipoDos:id,nombre',
            ])
            ->where('status', '!=', 'canceled')
            ->orderByRaw("FIELD(status, 'pending', 'polling', 'fetching', 'failed', 'completed', 'canceled')")
            ->orderBy('scheduled_at')
            ->get();

        return view('modulos.admin.match-score-requests', compact('requests'));
    }

    public function create()
    {
        $partidos = Partido::query()
            ->whereNotNull('api_fixture_id')
            ->where('fecha_partido', '>', now())
            ->whereDoesntHave('scoreRequest', function ($q) {
                $q->whereIn('status', MatchScoreRequest::ACTIVE_STATUSES);
            })
            ->with([
                'jornada:id,name',
                'equipos.equipoUno:id,nombre',
                'equipos.equipoDos:id,nombre',
            ])
            ->orderBy('fecha_partido')
            ->get();

        $grouped = $partidos->groupBy(fn ($p) => $p->jornada?->name ?? 'Sin jornada');

        return view('modulos.admin.match-score-request-form', compact('grouped'));
    }

    public function store(StoreMatchScoreRequestRequest $request, MatchScoreService $service)
    {
        $ids = $request->validated('partido_ids');

        $partidos = Partido::whereIn('id', $ids)->get();

        $scheduled = 0;
        $skipped   = 0;

        foreach ($partidos as $partido) {
            $result = $service->scheduleScorePolling($partido);

            $result ? $scheduled++ : $skipped++;
        }

        $message = "Se agendaron {$scheduled} partido(s) para la notificación de marcador.";

        if ($skipped > 0) {
            $message .= " {$skipped} se omitieron por datos faltantes.";
        }

        return redirect()
            ->route('web.admin.match-score-requests.index')
            ->with('status', $message);
    }

    public function destroy(MatchScoreRequest $matchScoreRequest, MatchScoreService $service)
    {
        $partido = $matchScoreRequest->partido;

        if (! $partido) {
            return redirect()
                ->route('web.admin.match-score-requests.index')
                ->with('error', 'No se encontró el partido asociado.');
        }

        $canceled = $service->cancelScorePolling($partido);

        if (! $canceled) {
            return redirect()
                ->route('web.admin.match-score-requests.index')
                ->with('warning', 'La notificación de marcador no estaba activa o ya había finalizado.');
        }

        return redirect()
            ->route('web.admin.match-score-requests.index')
            ->with('status', 'Notificación de marcador cancelada correctamente.');
    }
}
