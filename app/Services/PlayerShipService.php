<?php

namespace App\Services;

use App\Models\Player;
use App\Models\PlayerShip;
use App\Models\Ship;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PlayerShipService
{
    protected $apiKey;
    protected $apiUrl = "https://api.worldofwarships.eu/wows/ships/stats/";

    public function __construct()
    {
        $this->apiKey = config('services.wargaming.api_key');
    }

    private function extractBattleStats($stats, $battleType)
    {
        return [
            'battles' => $stats[$battleType]['battles'] ?? 0,
            'wins' => $stats[$battleType]['wins'] ?? 0,
            'damage_dealt' => $stats[$battleType]['damage_dealt'] ?? 0,
            'frags' => $stats[$battleType]['frags'] ?? 0,
            'xp' => $stats[$battleType]['xp'] ?? 0,
            'survived_battles' => $stats[$battleType]['survived_battles'] ?? 0,
            'distance' => $stats[$battleType]['distance'] ?? 0,
        ];
    }

    public function fetchAndStorePlayerShips()
    {
        Log::info('Starting fetchAndStorePlayerShips');

        try {
            $playerIds = Player::pluck('account_id')->all();
            Log::info("Data loaded", ['players_count' => count($playerIds)]);

            foreach ($playerIds as $playerId) {
                $response = Http::get($this->apiUrl, [
                    'application_id' => $this->apiKey,
                    'account_id' => $playerId,
                    'extra' => 'pve,club,pvp_solo,rank_solo'
                ]);

                if ($response->successful()) {
                    $data = $response->json();

                    if (isset($data['data'][$playerId])) {
                        foreach ($data['data'][$playerId] as $shipStats) {
                            // Find the ship using ship_id from the API
                            $ship = Ship::where('ship_id', $shipStats['ship_id'])->first();

                            if (!$ship) {
                                Log::warning("Ship not found in database", [
                                    'api_ship_id' => $shipStats['ship_id'],
                                    'player_id' => $playerId
                                ]);
                                continue;
                            }

                            // Extract statistics for different battle types
                            $pvpStats = [];
                            $pveStats = [];
                            $clubStats = [];
                            $rankStats = [];

                            if (isset($shipStats['pvp'])) {
                                $pvpStats = $this->extractBattleStats($shipStats, 'pvp');
                            }

                            if (isset($shipStats['pve'])) {
                                $pveStats = $this->extractBattleStats($shipStats, 'pve');
                            }

                            if (isset($shipStats['club'])) {
                                $clubStats = $this->extractBattleStats($shipStats, 'club');
                            }

                            if (isset($shipStats['rank_solo'])) {
                                $rankStats = $this->extractBattleStats($shipStats, 'rank_solo');
                            }





                            // Calculate total battles
                            $totalBattles = ($pvpStats['battles'] ?? 0) + ($pveStats['battles'] ?? 0) + ($clubStats['battles'] ?? 0) + ($rankStats['battles'] ?? 0);

                            // Calculate average damage
                            $totalDamageDealt = ($pvpStats['damage_dealt'] ?? 0) + ($pveStats['damage_dealt'] ?? 0) + ($clubStats['damage_dealt'] ?? 0) + ($rankStats['damage_dealt'] ?? 0);
                            $averageDamage = $totalBattles > 0 ? $totalDamageDealt / $totalBattles : 0;

                            // Calculate survival rate
                            $totalSurvivedBattles = ($pvpStats['survived_battles'] ?? 0) + ($pveStats['survived_battles'] ?? 0) + ($clubStats['survived_battles'] ?? 0) + ($rankStats['survived_battles'] ?? 0);
                            $survivalRate = $totalBattles > 0 ? ($totalSurvivedBattles / $totalBattles) * 100 : 0;

                            Log::info("Processing ship stats", [
                                'ship_id' => $ship->id,
                                'pvp_battles' => $pvpStats['battles'] ?? 0,
                                'pve_battles' => $pveStats['battles'] ?? 0,
                                'club_battles' => $clubStats['battles'] ?? 0,
                                'rank_battles' => $rankStats['battles'] ?? 0,
                                'total_battles' => $totalBattles,
                                'distance' => 'distance',
                            ]);

                            // Use ship->id instead of ship_id from API
                            PlayerShip::updateOrCreate(
                                [
                                    'account_id' => $playerId,
                                    'ship_id' => $ship->id
                                ],
                                [
                                    'battles_played' => $totalBattles,
                                    'wins_count' => ($pvpStats['wins'] ?? 0) + ($pveStats['wins'] ?? 0),
                                    'damage_dealt' => $totalDamageDealt,
                                    'average_damage' => $averageDamage,
                                    'frags' => ($pvpStats['frags'] ?? 0) + ($pveStats['frags'] ?? 0),
                                    'survival_rate' => $survivalRate,
                                    'distance' => $shipStats['distance'],
                                    // PVE stats
                                    'pve_battles' => $pveStats['battles'] ?? 0,
                                    'pve_wins' => $pveStats['wins'] ?? 0,
                                    'pve_frags' => $pveStats['frags'] ?? 0,
                                    'pve_xp' => $pveStats['xp'] ?? 0,
                                    'pve_survived_battles' => $pveStats['survived_battles'] ?? 0,
                                    // PVP stats
                                    'pvp_battles' => $pvpStats['battles'] ?? 0,
                                    'pvp_wins' => $pvpStats['wins'] ?? 0,
                                    'pvp_frags' => $pvpStats['frags'] ?? 0,
                                    'pvp_xp' => $pvpStats['xp'] ?? 0,
                                    'pvp_survived_battles' => $pvpStats['survived_battles'] ?? 0,
                                    // Club stats
                                    'club_battles' => $clubStats['battles'] ?? 0,
                                    'club_wins' => $clubStats['wins'] ?? 0,
                                    'club_frags' => $clubStats['frags'] ?? 0,
                                    'club_xp' => $clubStats['xp'] ?? 0,
                                    'club_survived_battles' => $clubStats['survived_battles'] ?? 0,
                                    //Rank stats
                                    'rank_battles' => $rankStats['battles'] ?? 0,
                                    'rank_wins' => $rankStats['wins'] ?? 0,
                                    'rank_frags' => $rankStats['frags'] ?? 0,
                                    'rank_xp' => $rankStats['xp'] ?? 0,
                                    'rank_survived_battles' => $rankStats['survived_battles'] ?? 0,
                                ]
                            );
                        }
                    }
                } else {
                    Log::error("Failed to fetch player ships", [
                        'account_id' => $playerId,
                        'status' => $response->status(),
                        'response' => $response->body()
                    ]);
                }
            }

            return true;
        } catch (\Exception $e) {
            Log::error("Error in fetchAndStorePlayerShips", [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
