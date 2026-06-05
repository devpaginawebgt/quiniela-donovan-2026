<?php

namespace App\Console\Commands;

use App\Http\Services\ApiFootballService;
use App\Http\Services\MatchService;
use App\Mail\SystemNotification;
use App\Models\ApiFixture;
use App\Models\Jornada;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SincronizarFixtures extends Command
{
    protected $signature = 'app:sincronizar-fixtures
                            {--jornada= : ID interno de la Jornada local a sincronizar (obligatorio)}
                            {--league=1 : ID de la liga en API-Football (1 = FIFA World Cup)}
                            {--season=2026 : Temporada}';

    protected $description = 'Sincroniza los fixtures (api_fixtures) de una Jornada local desde API-Football usando su api_round enlazado, y proyecta los partidos al dominio (partidos + equipo_partidos).';

    public function handle(ApiFootballService $api, MatchService $matchService)
    {
        $jornadaId = $this->option('jornada');

        if (! $jornadaId) {
            $this->error('Debes especificar --jornada=<id>.');
            return Command::INVALID;
        }

        $jornada = Jornada::find((int) $jornadaId);

        if (! $jornada) {
            $this->error("No existe Jornada con id {$jornadaId}.");
            return Command::FAILURE;
        }

        if (! $jornada->api_round) {
            $this->error("Jornada [{$jornada->id}] '{$jornada->name}' no tiene api_round asignado.");
            $this->line('Corre primero: php artisan app:sincronizar-rondas');
            return Command::FAILURE;
        }

        $league = (int) $this->option('league');
        $season = (int) $this->option('season');

        $this->info("Sincronizando fixtures de Jornada [{$jornada->id}] '{$jornada->name}' → '{$jornada->api_round}'...");

        $apiResult = $api->getFixtures($jornada->api_round, $league, $season);

        if ($apiResult['error'] === true) {
            $this->error('No se pudieron obtener los fixtures del API.');
            return Command::FAILURE;
        }

        $this->info("Fixtures sincronizados desde API: {$apiResult['synced']}");

        $fixtures = ApiFixture::where('round', $jornada->api_round)
            ->where('league_id', $league)
            ->where('season', $season)
            ->get();

        if ($fixtures->isEmpty()) {
            $this->warn('No hay fixtures en api_fixtures para esta ronda. Nada que proyectar a partidos.');
            return Command::SUCCESS;
        }

        $this->newLine();
        $this->info('Proyectando fixtures a partidos locales...');

        $matchResult = $matchService->getMatches($fixtures);

        if ($matchResult['error'] === true) {
            $this->error('Ocurrió una excepción durante la proyección. Revisa logs.');
        }

        $this->newLine();
        $this->line("  Partidos creados:        {$matchResult['created']}");
        $this->line("  Enlazados (backfill):    {$matchResult['linked']}");
        $this->line("  Fechas actualizadas:     {$matchResult['updated']}");
        $this->line("  Omitidos (sin cambios):  {$matchResult['skipped']}");

        $pendingDates = $fixtures->filter(
            fn ($f) => in_array($f->status_short, ['TBD', 'PST'], true)
        );

        $jornada->update([
            'fixtures'              => $fixtures->count(),
            'fixtures_pending_date' => $pendingDates->count(),
        ]);

        $this->info("Contadores de Jornada actualizados: fixtures={$fixtures->count()}, fixtures_pending_date={$pendingDates->count()}.");

        $emailBody  = "Sincronización de fixtures completada para Jornada [{$jornada->id}] '{$jornada->name}' → '{$jornada->api_round}'.\n\n";
        $emailBody .= "Fixtures sincronizados desde API: {$apiResult['synced']}\n\n";
        $emailBody .= "Proyectando fixtures a partidos locales...\n\n";
        $emailBody .= "  Partidos creados:        {$matchResult['created']}\n";
        $emailBody .= "  Enlazados (backfill):    {$matchResult['linked']}\n";
        $emailBody .= "  Fechas actualizadas:     {$matchResult['updated']}\n";
        $emailBody .= "  Omitidos (sin cambios):  {$matchResult['skipped']}\n\n";
        $emailBody .= "Contadores de Jornada: fixtures={$fixtures->count()}, fixtures_pending_date={$pendingDates->count()}.\n\n";

        if ($pendingDates->isNotEmpty()) {
            $this->newLine();
            $this->warn("ATENCIÓN: {$pendingDates->count()} partido(s) con fecha aún por definirse o reprogramar.");
            $this->line('Deberás volver a correr este comando cuando la API actualice las fechas:');

            $emailBody .= "ATENCIÓN: {$pendingDates->count()} partido(s) con fecha aún por definirse o reprogramar.\n";
            $emailBody .= "Deberás volver a correr este comando cuando la API actualice las fechas:\n";

            foreach ($pendingDates as $f) {
                $line = "  - Fixture {$f->api_fixture_id}: home={$f->api_home_team_id} vs away={$f->api_away_team_id} (status: {$f->status_short})";
                $this->line($line);
                $emailBody .= $line . "\n";
            }
        } else {
            $this->newLine();
            $this->info('Todas las fechas de la ronda están confirmadas.');
            $emailBody .= "Todas las fechas de la ronda están confirmadas.\n";
        }

        $to = config('quiniela.system_notifications_email');

        if (empty($to)) {
            $this->warn('Email de reporte no enviado: SYSTEM_NOTIFICATIONS_EMAIL no está configurado.');
        } else {
            $subject = "Sincronización fixtures — Jornada {$jornada->id} '{$jornada->name}'";
            Mail::to($to)->send(new SystemNotification($subject, $emailBody));
            $this->info("Reporte enviado por email a {$to}.");
        }

        return $matchResult['error'] === true ? Command::FAILURE : Command::SUCCESS;
    }
}
