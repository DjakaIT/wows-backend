<?php

namespace App\Services;

use App\Models\Player;
use App\Models\PlayerStatistic;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PlayerStatisticService
{
    protected $apiUrl = 'https://api.worldofwarships.eu/wows/account/info/';
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.wargaming.api_key');
    }

    public function fetchAndStorePlayerStats()
    {
        Log::info('Starting fetchAndStorePlayerStats');
        try {
            $playerIds = Player::pluck('account_id')->all();
            Log::info('Data loaded', ['player_count' => count($playerIds)]);

            foreach ($playerIds as $playerId) {
                $response = Http::get($this->apiUrl, [
                    'application_id' => $this->apiKey,
                    'account_id' => $playerId,
                    'extra' => 'statistics.club,statistics.clan,statistics.pve,statistics.pvp_solo,statistics.rank_solo,private.port'
                ]);

                if ($response->successful()) {
                    $data = $response->json();

                    if (isset($data['data'][$playerId])) {
                        $playerStats = $data['data'][$playerId];

                        // Summing shared fields
                        $shipsSpottedTotal = ($playerStats['statistics']['club']['ships_spotted'] ?? 0)
                            + ($playerStats['statistics']['pvp_solo']['ships_spotted'] ?? 0)
                            + ($playerStats['statistics']['pve']['ships_spotted'] ?? 0)
                            + ($playerStats['statistics']['rank_solo']['ships_spotted'] ?? 0);

                        $damageDealtTotal = ($playerStats['statistics']['club']['damage_dealt'] ?? 0)
                            + ($playerStats['statistics']['pvp_solo']['damage_dealt'] ?? 0)
                            + ($playerStats['statistics']['pve']['damage_dealt'] ?? 0)
                            + ($playerStats['statistics']['rank_solo']['damage_dealt'] ?? 0);

                        $fragsTotal = ($playerStats['statistics']['club']['frags'] ?? 0)
                            + ($playerStats['statistics']['pvp_solo']['frags'] ?? 0)
                            + ($playerStats['statistics']['pve']['frags'] ?? 0)
                            + ($playerStats['statistics']['rank_solo']['frags'] ?? 0);

                        $xpTotal = ($playerStats['statistics']['club']['xp'] ?? 0)
                            + ($playerStats['statistics']['pvp_solo']['xp'] ?? 0)
                            + ($playerStats['statistics']['pve']['xp'] ?? 0)
                            + ($playerStats['statistics']['rank_solo']['xp'] ?? 0);

                        $winsTotal = ($playerStats['statistics']['club']['wins'] ?? 0)
                            + ($playerStats['statistics']['pvp_solo']['wins'] ?? 0)
                            + ($playerStats['statistics']['pve']['wins'] ?? 0)
                            + ($playerStats['statistics']['rank_solo']['wins'] ?? 0);

                        $lossesTotal = ($playerStats['statistics']['club']['losses'] ?? 0)
                            + ($playerStats['statistics']['pvp_solo']['losses'] ?? 0)
                            + ($playerStats['statistics']['pve']['losses'] ?? 0)
                            + ($playerStats['statistics']['rank_solo']['losses'] ?? 0);

                        $survived_battlesTotal = ($playerStats['statistics']['club']['survived_battles'] ?? 0)
                            + ($playerStats['statistics']['pvp_solo']['survived_battles'] ?? 0)
                            + ($playerStats['statistics']['pve']['survived_battles'] ?? 0)
                            + ($playerStats['statistics']['rank_solo']['survived_battles'] ?? 0);

                        // Storing values in PlayerStatistic model
                        PlayerStatistic::updateOrCreate(
                            [
                                'account_id' => $playerId,
                            ],
                            [
                                'nickname' => $playerStats['nickname'],
                                'karma' => $playerStats['karma'] ?? null,
                                'private_battle_life_time' => $playerStats['private']['battle_life_time'] ?? null,
                                'private_gold' => $playerStats['private']['gold'] ?? null,
                                'private_port' => $playerStats['private']['port'] ?? null,
                                'battles_played' => $playerStats['statistics']['battles'],
                                'damage_dealt' => $damageDealtTotal,
                                'ships_spotted' => $shipsSpottedTotal,
                                'wins' => $winsTotal,
                                'losses' => $lossesTotal,
                                'survived_battles' => $survived_battlesTotal,
                                'frags' => $fragsTotal,
                                'xp' => $xpTotal,
                                'distance' => $playerStats['statistics']['distance'] ?? 0,
                            ]
                        );
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error("Error fetching player stats: " . $e->getMessage());
        }
    }
}
