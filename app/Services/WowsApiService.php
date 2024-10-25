<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WowsApiService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.wargaming.api_key');
    }

    public function getClans($clanTag)
    {
        $url = "https://api.worldofwarships.eu/wows/clans/list/";

        try {
            $response = Http::get($url, [
                'application_id' => $this->apiKey,
            ]);

            if ($response->failed()) {
                Log::error("API Request failed with status: " . $response->status());
                Log::error("Full API Response", ['response' => $response->body()]);
                return null;
            }

            if ($response->successful()) {
                Log::info("API Success Response", $response->json());
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::error("Exception during API Call: " . $e->getMessage());
        }

        return null;
    }
}
