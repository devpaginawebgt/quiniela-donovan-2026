<?php

namespace App\Console\Commands;

use App\Http\Services\ApiFootballService;
use App\Models\ApiTeam;
use App\Models\Equipo;
use Illuminate\Console\Command;

class SincronizarEquipos extends Command
{
    protected $signature = 'app:sincronizar-equipos
                            {--league=1 : ID de la liga en API-Football (1 = FIFA World Cup)}
                            {--season=2026 : Temporada}
                            {--force : Re-enlaza equipos aunque ya tengan api_team_id}';

    protected $description = 'Sincroniza ApiTeams desde API-Football y enlaza Equipo.api_team_id por code (FIFA alpha-3)';

    public function handle(ApiFootballService $api)
    {
        $league = (int) $this->option('league');
        $season = (int) $this->option('season');
        $force  = (bool) $this->option('force');

        $this->info("Pidiendo /teams?league={$league}&season={$season}...");

        $result = $api->getTeams($league, $season);

        if ($result['error']) {
            $this->error('No se pudo obtener equipos de API-Football. Revisa api_responses para más detalle.');
            return Command::FAILURE;
        }

        $this->info("ApiTeams sincronizados (updateOrCreate): {$result['synced']}");

        $query = Equipo::query();

        if (! $force) {
            $query->whereNull('api_team_id');
        }

        $equipos = $query->get();

        if ($equipos->isEmpty()) {
            $this->info($force
                ? 'No hay equipos en la base.'
                : 'Todos los equipos ya tienen api_team_id. Usa --force para re-enlazar.');
            return Command::SUCCESS;
        }

        $this->info("Enlazando {$equipos->count()} equipos...");

        $linked    = 0;
        $unchanged = 0;
        $unmatched = [];

        foreach ($equipos as $equipo) {
            if (! $equipo->code) {
                $unmatched[] = "{$equipo->nombre} (code vacío)";
                continue;
            }

            $apiTeam = ApiTeam::where('code', strtoupper($equipo->code))->first();

            if (! $apiTeam) {
                $unmatched[] = "{$equipo->nombre} (code={$equipo->code}) sin ApiTeam coincidente";
                continue;
            }

            if ((int) $equipo->api_team_id === (int) $apiTeam->api_team_id) {
                $unchanged++;
                continue;
            }

            $equipo->update(['api_team_id' => $apiTeam->api_team_id]);
            $linked++;
        }

        $this->newLine();
        $this->info("Enlazados/actualizados: {$linked}");
        $this->info("Sin cambios (ya enlazados correctamente): {$unchanged}");

        if (! empty($unmatched)) {
            $this->warn('Equipos sin coincidencia (revisa el campo code o que API devuelva ese equipo):');
            foreach ($unmatched as $u) {
                $this->line(" - {$u}");
            }
        }

        return Command::SUCCESS;
    }
}
