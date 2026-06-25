<?php

namespace App\Console\Commands;

use App\Http\Services\ApiFootballService;
use App\Http\Services\PartidoService;
use App\Mail\SystemNotification;
use App\Models\Jornada;
use App\Models\Partido;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

class SincronizarRondas extends Command
{
    protected $signature = 'app:sincronizar-rondas
                            {--league=1 : ID de la liga en API-Football (1 = FIFA World Cup)}
                            {--season=2026 : Temporada}
                            {--force : Re-enlaza jornadas aunque ya tengan api_round asignado}';

    protected $description = 'Obtiene las rondas desde API-Football, las escribe en jornadas.api_round por índice, dispara sync de fixtures donde haga falta, marca jornadas completed y envía email digest.';

    public function handle(ApiFootballService $api)
    {
        $league = (int) $this->option('league');
        $season = (int) $this->option('season');
        $force  = (bool) $this->option('force');

        $this->info("Pidiendo /fixtures/rounds?league={$league}&season={$season}...");

        $result = $api->getRounds($league, $season);

        if ($result['error'] === true) {
            $this->error('No se pudieron obtener las rondas del API.');
            return Command::FAILURE;
        }

        $rounds   = $result['rounds'];
        $jornadas = Jornada::orderBy('id')->get();

        $this->info("Rondas del API: " . count($rounds));
        $this->info("Jornadas locales: {$jornadas->count()}");
        $this->newLine();

        $linked    = 0;
        $unchanged = 0;
        $sinRonda  = 0;

        foreach ($jornadas->values() as $i => $jornada) {
            if (! array_key_exists($i, $rounds)) {
                $sinRonda++;
                $this->line("· Jornada [{$jornada->id}] '{$jornada->name}' sin ronda en API (índice {$i}), skip.");
                continue;
            }

            $roundName = $rounds[$i];

            if ($jornada->api_round === $roundName) {
                $unchanged++;
                continue;
            }

            if ($jornada->api_round && ! $force) {
                $this->line("→ Jornada [{$jornada->id}] '{$jornada->name}' ya tiene api_round '{$jornada->api_round}', skip (usa --force para sobrescribir con '{$roundName}').");
                continue;
            }

            $jornada->update(['api_round' => $roundName]);
            $linked++;
            $this->line("✓ Jornada [{$jornada->id}] '{$jornada->name}' → '{$roundName}'");
        }

        $this->newLine();
        $this->info("Enlazadas/actualizadas: {$linked}");
        $this->info("Sin cambios (ya enlazadas correctamente): {$unchanged}");

        if ($sinRonda > 0) {
            $this->warn("Jornadas sin ronda en API (no actualizadas): {$sinRonda}");
        }

        $this->newLine();
        $this->info('Evaluando jornadas para disparar sincronización de fixtures...');

        $triggered = 0;
        $skipped   = 0;
        $failed    = 0;

        foreach (Jornada::whereNotNull('api_round')->orderBy('id')->get() as $jornada) {
            if ($jornada->completed) {
                $skipped++;
                $this->line("· Jornada [{$jornada->id}] '{$jornada->name}' completed=true, skip.");
                continue;
            }

            $expectedMatches = 24;

            switch((int)$jornada->id) {
                case 4:
                    $expectedMatches = 16;
                    break;
                case 5:
                    $expectedMatches = 8;
                    break;
                case 6:
                    $expectedMatches = 4;
                    break;
                case 7:
                    $expectedMatches = 2;
                    break;
                case 8:
                    $expectedMatches = 1;
                    break;
                case 9:
                    $expectedMatches = 1;
                    break;
                default:
                    $expectedMatches = 24;
                    break;
            }

            $currentFixtures = (int)$jornada->fixtures;
            $pendingDate     = (int)$jornada->fixtures_pending_date;
            $hasAllMatches   = $currentFixtures >= $expectedMatches;

            $needsSync = $currentFixtures === 0 || $pendingDate > 0 || ! $hasAllMatches;

            if (! $needsSync) {
                $skipped++;
                $this->line("· Jornada [{$jornada->id}] '{$jornada->name}' sin pendientes (fixtures={$currentFixtures}/{$expectedMatches}, pending_date={$pendingDate}), skip.");
                continue;
            }

            $reason = $currentFixtures === 0
                ? 'sin fixtures'
                : (! $hasAllMatches
                    ? "fixtures incompletos ({$currentFixtures}/{$expectedMatches})"
                    : "pending={$pendingDate}");

            $this->info("→ Disparando app:sincronizar-fixtures para Jornada [{$jornada->id}] '{$jornada->name}' ({$reason})...");

            $exitCode = Artisan::call('app:sincronizar-fixtures', [
                '--jornada' => $jornada->id,
                '--league'  => $league,
                '--season'  => $season,
            ]);

            $this->line(Artisan::output());

            if ($exitCode === Command::SUCCESS) {
                $triggered++;
            } else {
                $failed++;
                $this->warn("✗ app:sincronizar-fixtures falló para Jornada [{$jornada->id}] (exit code {$exitCode}). Continuando con las siguientes.");
            }
        }

        $this->newLine();
        $this->info("Triggered: {$triggered}, omitidos (sin pendientes o completados): {$skipped}, fallidos: {$failed}");

        $this->newLine();
        $this->info('Evaluando flag `completed` por jornada...');

        $markedCompleted = 0;
        $alreadyCompleted = 0;
        $notCompleted = 0;

        foreach (Jornada::orderBy('id')->get() as $jornada) {
            $hasPartidos = Partido::where('jornada_id', $jornada->id)->exists();

            $isCompleted = $hasPartidos
                && ! Partido::where('jornada_id', $jornada->id)
                    ->where('estado', '!=', 1)
                    ->exists();

            if (! $isCompleted) {
                $notCompleted++;
                continue;
            }

            if ($jornada->completed) {
                $alreadyCompleted++;
                continue;
            }

            $jornada->update(['completed' => true]);
            $markedCompleted++;
            $this->line("✓ Jornada [{$jornada->id}] '{$jornada->name}' marcada como completada.");
        }

        $this->info("Marcadas completadas ahora: {$markedCompleted} | ya completadas: {$alreadyCompleted} | en curso: {$notCompleted}");

        $this->newLine();
        $this->info('Safety-net: ejecutando PartidoService::verifyJourneyStatus()...');
        app(PartidoService::class)->verifyJourneyStatus();

        $emailBody  = "Sincronización de rondas completada (league={$league}, season={$season}).\n\n";
        $emailBody .= "Rondas del API:                          " . count($rounds) . "\n";
        $emailBody .= "Jornadas locales:                        {$jornadas->count()}\n\n";
        $emailBody .= "Enlazadas/actualizadas:                  {$linked}\n";
        $emailBody .= "Sin cambios (ya enlazadas):              {$unchanged}\n";
        $emailBody .= "Sin ronda en API:                        {$sinRonda}\n\n";
        $emailBody .= "Sincronización de fixtures disparada:\n";
        $emailBody .= "  Triggered:                             {$triggered}\n";
        $emailBody .= "  Omitidos (sin pendientes/completados): {$skipped}\n";
        $emailBody .= "  Fallidos:                              {$failed}\n\n";

        $emailBody .= "Flag `completed`:\n";
        $emailBody .= "  Marcadas completadas ahora:            {$markedCompleted}\n";
        $emailBody .= "  Ya completadas:                        {$alreadyCompleted}\n";
        $emailBody .= "  En curso:                              {$notCompleted}\n\n";

        $emailBody .= "Detalle por jornada:\n";
        foreach ($jornadas as $j) {
            $roundLabel = $j->api_round ?: '(sin api round)';
            $emailBody .= "  - {$j->name} - {$roundLabel}\n";
        }

        $emailBody .= "\nNota: cada Sincronizar Fixtures disparado envía su propio email con el detalle por jornada.\n";

        $to = config('quiniela.system_notifications_email');

        if (empty($to)) {
            $this->warn('Email de reporte no enviado: SYSTEM_NOTIFICATIONS_EMAIL no está configurado.');
        } else {
            $subject = "Sincronización de rondas — league {$league}, season {$season}";
            Mail::to($to)->send(new SystemNotification($subject, $emailBody));
            $this->info("Reporte enviado por email a {$to}.");
        }

        return Command::SUCCESS;
    }
}
