<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;

class PlayerService
{

    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.wargaming.api_key');
    }

    public function getPlayers($server, $page = 1, $limit = 100, $search)
    {

        $url = "https://api.worldofwarships.eu/wows/account/list/?application_id=a1475a1b88177cf974be1eb48af3d4a8";


        try {
            $response = Http::get($url, [
                'application_id' => $this->apiKey,
                'search' => $search,
                'page_no,' => $page,
                'limit' => $limit,
            ]);


            if ($response->failed()) {
                Log::error("Player API Request failed with status: " . $response->status());
                Log::error("Full Player API Response", ['response' => $response->body()]);
                return null;
            }

            if ($response->successful()) {
                Log::info("Player API Success Response", $response->json());
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::error("Exception during Player API call: " . $e->getMessage());
        }

        return null;
    }
}
