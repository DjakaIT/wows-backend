<?php

namespace App\Services;

use App\Models\Player;
use App\Models\PlayerShip;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PlayerShipService
{

    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.wargaming.api_key');
    }
    protected $apiUrl = "https://api.worldofwarships.eu/wows/ships/stats/";

    public function fetchAndStorePlayerShips()
    {
        Log::info('called method fetchAndStorePlayerShips');

        try {
            // Get all player IDs
            $playerIds = Player::pluck('account_id')->all();
            Log::info("Started fetching players", ['total_players' => count($playerIds)]);

            foreach ($playerIds as $playerId) {
                Log::info("Fetching data for player", ['account_id' => $playerId]);

                $playerResponse = Http::get($this->apiUrl, [
                    'application_id' => $this->apiKey,
                    'account_id' => $playerId,
                ]);

                if ($playerResponse->successful()) {
                    // Fetch JSON response and check for expected structure
                    $responseData = $playerResponse->json();

                    // Confirm data structure
                    if (isset($responseData['data'][$playerId]) && is_array($responseData['data'][$playerId])) {
                        $playerShipsData = $responseData['data'][$playerId];

                        foreach ($playerShipsData as $playerShipData) {
                            PlayerShip::updateOrCreate(
                                [
                                    'player_id' => $playerId,
                                    'ship_id' => $playerShipData['ship_id'] ?? null, // Safely access ship_id
                                ],
                                [
                                    'battles_played' => $playerShipData['battles'] ?? 0,
                                    'wins_count' => $playerShipData['wins'] ?? 0,
                                    'damage_dealt' => $playerShipData['damage_dealt'] ?? 0,
                                    'average_damage' => $playerShipData['average_damage'] ?? 0,
                                    'frags' => $playerShipData['frags'] ?? 0,
                                    'survival_rate' => $playerShipData['survival_rate'] ?? 0,
                                ]
                            );
                        }
                    } else {
                        Log::warning("Unexpected data format or missing data for player", [
                            'account_id' => $playerId,
                            'response' => $responseData,
                        ]);
                    }
                } else {
                    Log::error("Failed to fetch data for player", [
                        'account_id' => $playerId,
                        'status' => $playerResponse->status(),
                        'response' => $playerResponse->body(),
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error in the method fetchAndStorePlayerShips', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
