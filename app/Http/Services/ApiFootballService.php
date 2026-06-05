<?php

namespace App\Http\Services;

use App\Models\ApiFixture;
use App\Models\ApiPlayer;
use App\Models\ApiResponse;
use App\Models\ApiTeam;
use Illuminate\Support\Facades\Http;

class ApiFootballService
{
    private string $base_url;
    private string $api_key;

    public function __construct()
    {
        $this->base_url = config('api-football.base_url', '');
        $this->api_key  = config('api-football.api_key', '');
    }

    private function request(string $endpoint): array
    {
        $response = Http::withHeaders([
            'x-apisports-key' => $this->api_key,
        ])->get($this->base_url . $endpoint);

        $body      = $response->json() ?? [];
        $hasErrors = ! empty($body['errors'] ?? []);
        $success   = $response->ok() && ! $hasErrors;

        ApiResponse::create([
            'endpoint'    => $body['get'] ?? trim(parse_url($endpoint, PHP_URL_PATH) ?? '', '/'),
            'parameters'  => $body['parameters'] ?? null,
            'errors'      => $body['errors'] ?? null,
            'results'     => $body['results'] ?? 0,
            'paging'      => $body['paging'] ?? null,
            'response'    => $success ? null : ($body['response'] ?? null),
            'status_code' => $response->status(),
            'success'     => $success,
        ]);

        if (! $success) {
            return [
                'error'   => true,
                'message' => 'No se pudo obtener la información de la API Football.',
            ];
        }

        return [
            'error' => false,
            'data'  => $body['response'] ?? [],
        ];
    }

    public function getTeams(int $league = 1, int $season = 2026): array
    {
        $result = $this->request("/teams?league={$league}&season={$season}");

        if ($result['error'] === true) {
            return ['error' => true, 'synced' => 0];
        }

        $synced = 0;

        foreach ($result['data'] as $entry) {
            $team = $entry['team'] ?? null;

            if (! $team || empty($team['id'])) continue;

            ApiTeam::updateOrCreate(
                ['api_team_id' => $team['id']],
                [
                    'name'     => $team['name'] ?? '',
                    'code'     => $team['code'] ?? null,
                    'country'  => $team['country'] ?? null,
                    'founded'  => $team['founded'] ?? null,
                    'national' => $team['national'] ?? false,
                    'logo'     => $team['logo'] ?? null,
                ]
            );

            $synced++;
        }

        return ['error' => false, 'synced' => $synced];
    }

    public function getRounds(int $league = 1, int $season = 2026): array
    {
        $params = http_build_query([
            'league' => $league,
            'season' => $season,
        ]);

        $result = $this->request("/fixtures/rounds?{$params}");

        if ($result['error'] === true) {
            return ['error' => true, 'rounds' => []];
        }

        $rounds = array_values(array_filter(
            $result['data'],
            fn ($r) => is_string($r) && $r !== ''
        ));

        return ['error' => false, 'rounds' => $rounds];
    }

    public function getFixtures(string $round, int $league = 1, int $season = 2026): array
    {
        $params = http_build_query([
            'league' => $league,
            'season' => $season,
            'round'  => $round,
        ]);

        $result = $this->request("/fixtures?{$params}");

        if ($result['error'] === true) {
            return ['error' => true, 'synced' => 0];
        }

        $now    = now();
        $synced = 0;

        foreach ($result['data'] as $entry) {
            if ($this->persistFixturePayload($entry, $league, $season, $round, $now)) {
                $synced++;
            }
        }

        return ['error' => false, 'synced' => $synced];
    }

    public function getFixture(int $apiFixtureId): array
    {
        $result = $this->request("/fixtures?id={$apiFixtureId}");

        if ($result['error'] === true) {
            return ['error' => true, 'fixture' => null];
        }

        $entry = $result['data'][0] ?? null;

        if (! $entry) {
            return ['error' => true, 'fixture' => null];
        }

        $fixture = $this->persistFixturePayload($entry, 0, 0, '', now());

        return ['error' => false, 'fixture' => $fixture];
    }

    private function persistFixturePayload(array $entry, int $league, int $season, string $round, $now): ?ApiFixture
    {
        $fixture = $entry['fixture'] ?? null;

        if (! $fixture || empty($fixture['id'])) return null;

        return ApiFixture::updateOrCreate(
            ['api_fixture_id' => $fixture['id']],
            [
                'league_id'        => $entry['league']['id']     ?? $league,
                'season'           => $entry['league']['season'] ?? $season,
                'round'            => $entry['league']['round']  ?? $round,
                'api_home_team_id' => $entry['teams']['home']['id'] ?? null,
                'api_away_team_id' => $entry['teams']['away']['id'] ?? null,
                'date'             => $fixture['date']             ?? null,
                'timezone'         => $fixture['timezone']         ?? null,
                'status_short'     => $fixture['status']['short']  ?? null,
                'status_long'      => $fixture['status']['long']   ?? null,
                'goals_home'       => $entry['goals']['home']      ?? null,
                'goals_away'       => $entry['goals']['away']      ?? null,
                'ft_goals_home'    => $entry['score']['fulltime']['home']  ?? null,
                'ft_goals_away'    => $entry['score']['fulltime']['away']  ?? null,
                'et_goals_home'    => $entry['score']['extratime']['home'] ?? null,
                'et_goals_away'    => $entry['score']['extratime']['away'] ?? null,
                'pt_goals_home'    => $entry['score']['penalty']['home']   ?? null,
                'pt_goals_away'    => $entry['score']['penalty']['away']   ?? null,
                'last_synced_at'   => $now,
            ]
        );
    }

    public function getTeamSquad(int $teamExternalId)
    {
        $result = $this->request("/players/squads?team={$teamExternalId}");

        if ($result['error'] === true) return;

        $entry   = $result['data'][0] ?? null;
        $players = $entry['players'] ?? [];

        if (empty($players)) return;

        $now          = now();
        $apiPlayerIds = [];

        foreach ($players as $player) {
            ApiPlayer::updateOrCreate(
                ['api_player_id' => $player['id']],
                [
                    'api_team_id'    => $teamExternalId,
                    'name'           => $player['name'],
                    'age'            => $player['age'] ?? null,
                    'number'         => $player['number'] ?? null,
                    'position'       => $player['position'] ?? null,
                    'photo'          => $player['photo'] ?? null,
                    'is_active'      => true,
                    'last_synced_at' => $now,
                ]
            );

            $apiPlayerIds[] = $player['id'];
        }

        ApiPlayer::where('api_team_id', $teamExternalId)
            ->whereNotIn('api_player_id', $apiPlayerIds)
            ->update(['is_active' => false]);
    }
}
