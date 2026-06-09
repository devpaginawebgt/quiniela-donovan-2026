<?php

namespace App\Console\Commands;

use App\Http\Services\MatchScoreService;
use App\Models\MatchScoreRequest;
use Illuminate\Console\Command;

class ObtenerMarcadoresPendientes extends Command
{
    protected $signature = 'app:obtener-marcadores-pendientes
                            {--limit=50 : Máximo de requests a procesar por ejecución}';

    protected $description = 'Procesa MatchScoreRequest activos: consulta API-Football, detecta cambios de marcador y envía push notifications.';

    public function handle(MatchScoreService $matchScoreService): int
    {
        $limit = (int) $this->option('limit');

        $pending = MatchScoreRequest::whereIn('status', [
                MatchScoreRequest::STATUS_PENDING,
                MatchScoreRequest::STATUS_POLLING,
            ])
            ->where('scheduled_at', '<=', now())
            ->orderBy('scheduled_at')
            ->limit($limit)
            ->get();

        if ($pending->isEmpty()) {
            $this->info('No hay marcadores pendientes.');
            return Command::SUCCESS;
        }

        $this->info("Procesando {$pending->count()} petición(es) de marcador...");

        foreach ($pending as $request) {
            $matchScoreService->processScoreRequest($request);
        }

        $this->info('Listo.');
        return Command::SUCCESS;
    }
}
