<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PlayerService
{
    protected $apiKey;
    protected $baseUrls;

    public function __construct()
    {
        $this->apiKey = config('services.wargaming.api_key');

        // Define base URLs for each server region
        $this->baseUrls = [
            'eu' => 'https://api.worldofwarships.eu',
            'na' => 'https://api.worldofwarships.com',
            'asia' => 'https://api.worldofwarships.asia',
        ];
    }

    /**
     * Fetch all players for a given search term from the Wargaming API
     */
    public function getAllPlayers($server, $search)
    {
        if (!isset($this->baseUrls[$server])) {
            Log::error("Invalid server specified: {$server}");
            return null;
        }

        $url = $this->baseUrls[$server] . "/wows/account/list/";
        $allPlayers = [];
        $page = 1;
        $limit = 100;
        $maxPages = 5; // Stop after 5 pages to avoid infinite loop

        try {
            while (true) {
                $response = Http::get($url, [
                    'application_id' => $this->apiKey,
                    'search' => $search,
                    'page_no' => $page,
                    'limit' => $limit,
                ]);

                if ($response->failed()) {
                    Log::error("Player API Request failed with status: " . $response->status());
                    return null;
                }

                $responseData = $response->json();
                if ($responseData['status'] === 'ok' && isset($responseData['data'])) {
                    $players = $responseData['data'];
                    $allPlayers = array_merge($allPlayers, $players);

                    Log::info("Fetched page {$page} for search term '{$search}' with " . count($players) . " players.");

                    // Break if there are fewer than $limit players, indicating the last page
                    if (count($players) < $limit || $page >= $maxPages) {
                        break;
                    }

                    $page++;
                } else {
                    Log::error("Player API returned an error", ['error' => $responseData['error']]);
                    break;
                }
            }
        } catch (\Exception $e) {
            Log::error("Exception during Player API call: " . $e->getMessage());
            return null;
        }

        return $allPlayers;
    }
}