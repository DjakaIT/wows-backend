<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use Illuminate\Http\Request;
use App\Services\WowsApiService;
use Illuminate\Support\Facades\Log;

class ClanController extends Controller
{
    protected $wowsApiService;

    public function __construct(WowsApiService $wowsApiService)
    {
        $this->wowsApiService = $wowsApiService;
    }

    public function fetchAndStoreClans(Request $request)
    {
        Log::info("Reached fetchAndStoreClans method");

        $clanTag = $request->input('clan_tag');
        $clans = $this->wowsApiService->getClans($clanTag);

        if ($clans && isset($clans['data'])) {
            foreach ($clans['data'] as $clanData) {
                Clan::updateOrCreate(
                    ['clan_id' => $clanData['clan_id']],
                    [
                        'name' => $clanData['name'],
                        'tag' => $clanData['tag'],
                        'server' => 'EU'
                    ]
                );
            }

            return response()->json(['message' => 'Clans fetched and stored successfully'], 201);
        }

        return response()->json(['message' => 'Failed to fetch clans'], 400);
    }
}
