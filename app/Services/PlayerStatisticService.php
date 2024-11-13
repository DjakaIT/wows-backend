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
        $this->apiKey->config('services.wargaming.api_key');
    }

    public function fetchAndStorePlayerStats()
    {
        try {
        } catch (\Exception $e) {
            Log::error("Error fetching achievements" . $e->getMessage());
        }
    }
}
