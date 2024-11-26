<?php

namespace App\Services;

use App\Models\Player;
use App\Models\PlayerShip;
use App\Models\Ship;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class PlayerShipService
{
    protected $apiKey;
    protected $apiUrl = "https://api.worldofwarships.eu/wows/ships/stats/";

    protected $expectedValues;
    public function __construct()
    {
        $this->apiKey = config('services.wargaming.api_key');
    }

    public function loadExpectedValues()
    {
        $path = resource_path('expected_values.json');
        if (!File::exists($path)) {
            Log::error("Expected values file not found at: $path");
            throw new \Exception("Expected values file not found");
        }

        $jsonContent = File::get($path);
        $decodedData = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error("Invalid JSON in expected values file", [
                'error' => json_last_error_msg(),
                'path' => $path
            ]);
            throw new \Exception("Invalid JSON in expected values file");
        }

        $this->expectedValues = $decodedData;
    }

    private function calculateWN8($ship, $totalBattles, $totalFrags, $totalWins, $totalDamageDealt)
    {
        $shipId = $ship->ship_id; // Extract the ship_id from the model

        if (
            !isset($this->expectedValues['data'][$shipId]) ||
            empty($this->expectedValues['data'][$shipId])
        ) {
            Log::warning("Expected values not found or empty for ship_id: $shipId");
            return null;
        }

        $expected = $this->expectedValues['data'][$shipId];

        $expectedDamage = $expected['average_damage_dealt'] * $totalBattles;
        $expectedFrags = $expected['average_frags'] * $totalBattles;
        $expectedWins = ($expected['win_rate'] / 100) * $totalBattles;

        // Ratios
        $rDmg = $expectedDamage > 0 ? $totalDamageDealt / $expectedDamage : 0;
        $rFrags = $expectedFrags > 0 ? $totalFrags / $expectedFrags : 0;
        $rWins = $expectedWins > 0 ? $totalWins / $expectedWins : 0;

        // Normalize
        $nDmg = max(0, ($rDmg - 0.4) / (1 - 0.4));
        $nFrags = max(0, ($rFrags - 0.1) / (1 - 0.1));
        $nWins = max(0, ($rWins - 0.7) / (1 - 0.7));

        // WN8 formula
        return (700 * $nDmg) + (300 * $nFrags) + (150 * $nWins);
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
        $this->loadExpectedValues();

        Log::info('Starting fetchAndStorePlayerShips');

        try {
            $playerIds = Player::pluck('account_id')->all();
            Log::info("Data loaded", ['players_count' => count($playerIds)]);

            foreach ($playerIds as $playerId) {
                $response = Http::get($this->apiUrl, [
                    'application_id' => $this->apiKey,
                    'account_id' => $playerId,
                    'extra' => 'pve,club,pve_div2,pve_div3,pve_solo,pvp_solo,pvp_div2,pvp_div3,rank_solo,rank_div2,rank_div3'
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

                            if (isset($shipStats['pvp_div2'])) {
                                $pvp2Stats = $this->extractBattleStats($shipStats, 'pvp_div2');
                            }

                            if (isset($shipStats['pvp_div3'])) {
                                $pvp3Stats = $this->extractBattleStats($shipStats, 'pvp_div3');
                            }

                            if (isset($shipStats['pve'])) {
                                $pveStats = $this->extractBattleStats($shipStats, 'pve');
                            }

                            if (isset($shipStats['pve_solo'])) {
                                $pve_soloStats = $this->extractBattleStats($shipStats, 'pve_solo');
                            }

                            if (isset($shipStats['pve_div2'])) {
                                $pve2Stats = $this->extractBattleStats($shipStats, 'pve_div2');
                            }

                            if (isset($shipStats['pve_div3'])) {
                                $pve3Stats = $this->extractBattleStats($shipStats, 'pve_div3');
                            }

                            if (isset($shipStats['club'])) {
                                $clubStats = $this->extractBattleStats($shipStats, 'club');
                            }

                            if (isset($shipStats['rank_solo'])) {
                                $rankStats = $this->extractBattleStats($shipStats, 'rank_solo');
                            }

                            if (isset($shipStats['rank_div2'])) {
                                $rank_div2Stats = $this->extractBattleStats($shipStats, 'rank_solo');
                            }

                            if (isset($shipStats['rank_div3'])) {
                                $rank_div3Stats = $this->extractBattleStats($shipStats, 'rank_solo');
                            }





                            // Calculate total battles
                            $totalBattles = ($pvpStats['battles'] ?? 0) + ($pveStats['battles'] ?? 0)
                                + ($clubStats['battles'] ?? 0) + ($rankStats['battles'] ?? 0)
                                + ($rank_div2Stats['battles'] ?? 0) + ($rank_div3Stats['battles'] ?? 0)
                                + ($pve_soloStats['battles'] ?? 0) + ($pve2Stats['battles'] ?? 0)
                                + ($pve3Stats['battles'] ?? 0) + ($pvp2Stats['battles'] ?? 0)
                                + ($pvp3Stats['battles'] ?? 0);

                            // Calculate total damage
                            $totalDamageDealt = ($pvpStats['damage_dealt'] ?? 0) + ($pveStats['damage_dealt'] ?? 0)
                                + ($clubStats['damage_dealt'] ?? 0) + ($rankStats['damage_dealt'] ?? 0)
                                + ($rank_div2Stats['damage_dealt'] ?? 0) + ($rank_div3Stats['damage_dealt'] ?? 0)
                                + ($pve_soloStats['damage_dealt'] ?? 0) + ($pve2Stats['damage_dealt'] ?? 0)
                                + ($pve3Stats['damage_dealt'] ?? 0) + ($pvp2Stats['damage_dealt'] ?? 0)
                                + ($pvp3Stats['damage_dealt'] ?? 0);
                            $averageDamage = $totalBattles > 0 ? $totalDamageDealt / $totalBattles : 0;

                            //calculate total wins
                            $totalWins = ($pvpStats['wins'] ?? 0) + ($pveStats['wins'] ?? 0)
                                + ($clubStats['wins'] ?? 0) + ($rankStats['wins'] ?? 0)
                                + ($rank_div2Stats['wins'] ?? 0) + ($rank_div3Stats['wins'] ?? 0)
                                + ($pve_soloStats['wins'] ?? 0) + ($pve2Stats['wins'] ?? 0)
                                + ($pve3Stats['wins'] ?? 0) + ($pvp2Stats['wins'] ?? 0)
                                + ($pvp3Stats['wins'] ?? 0);

                            //calculate total frags
                            $totalFrags = ($pvpStats['frags'] ?? 0) + ($pveStats['frags'] ?? 0)
                                + ($clubStats['frags'] ?? 0) + ($rankStats['frags'] ?? 0)
                                + ($rank_div2Stats['frags'] ?? 0) + ($rank_div3Stats['frags'] ?? 0)
                                + ($pve_soloStats['frags'] ?? 0) + ($pve2Stats['frags'] ?? 0)
                                + ($pve3Stats['frags'] ?? 0) + ($pvp2Stats['frags'] ?? 0)
                                + ($pvp3Stats['frags'] ?? 0);


                            // Calculate survival rate
                            $totalSurvivedBattles = ($pvpStats['survived_battles'] ?? 0) + ($pveStats['survived_battles'] ?? 0) + ($clubStats['survived_battles'] ?? 0) + ($rankStats['survived_battles'] ?? 0);
                            $survivalRate = $totalBattles > 0 ? ($totalSurvivedBattles / $totalBattles) * 100 : 0;



                            Log::info("Processing ship stats", [
                                'ship_id' => $ship->ship_id,
                                'pvp_battles' => $pvpStats['battles'] ?? 0,
                                'pve_battles' => $pveStats['battles'] ?? 0,
                                'club_battles' => $clubStats['battles'] ?? 0,
                                'rank_battles' => $rankStats['battles'] ?? 0,
                                'total_battles' => $totalBattles,
                                'distance' => 'distance',
                            ]);

                            //wn8
                            $wn8 =  $this->calculateWN8($ship, $totalBattles, $totalFrags, $totalWins, $totalDamageDealt);

                            // Use ship->id instead of ship_id from API
                            PlayerShip::updateOrCreate(
                                [
                                    'account_id' => $playerId,
                                    'ship_id' => $shipStats['ship_id']
                                ],
                                [
                                    'battles_played' => $totalBattles,
                                    'wins_count' => $totalWins,
                                    'damage_dealt' => $totalDamageDealt,
                                    'average_damage' => $averageDamage,
                                    'frags' => $totalFrags,
                                    'survival_rate' => $survivalRate,
                                    'distance' => $shipStats['distance'],
                                    'wn8' => $wn8,
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
