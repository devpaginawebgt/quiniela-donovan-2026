<?php

namespace App\Console\Commands;

use App\Http\Services\MatchService;
use App\Models\MatchResultRequest;
use Illuminate\Console\Command;

class ObtenerResultadosPendientes extends Command
{
    protected $signature = 'app:obtener-resultados-pendientes
                            {--limit=50 : Máximo de requests a procesar por ejecución}';

    protected $description = 'Procesa MatchResultRequest pendientes: consulta API-Football, crea resultados o reagenda.';

    public function handle(MatchService $matchService): int
    {
        $limit = (int) $this->option('limit');

        $pending = MatchResultRequest::where('status', MatchResultRequest::STATUS_PENDING)
            ->where('scheduled_at', '<=', now())
            ->orderBy('scheduled_at')
            ->limit($limit)
            ->get();

        if ($pending->isEmpty()) {
            $this->info('No hay peticiones pendientes.');
            return Command::SUCCESS;
        }

        $this->info("Procesando {$pending->count()} petición(es)...");

        foreach ($pending as $request) {
            $matchService->processResultRequest($request);
        }

        $this->info('Listo.');
        return Command::SUCCESS;
    }
}
