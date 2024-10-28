<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use Illuminate\Http\Request;
use App\Services\ClanService;
use Illuminate\Support\Facades\Log;

class ClanController extends Controller
{
    protected $ClanService;

    public function __construct(ClanService $clanService)
    {
        $this->ClanService = $clanService;
    }

    public function fetchAndStoreClans(Request $request)
    {
        Log::info("Reached fetchAndStoreClans method");

        $servers = ['eu', 'na', 'asia'];
        $limit = 100;
        foreach ($servers as $server) {
            $page = 1;
            $hasMore = true;

            while ($hasMore) {
                $clans = $this->ClanService->getClans($server, $page, $limit);

                if ($clans && isset($clans['data'])) {
                    foreach ($clans['data'] as $clanData) {
                        Clan::updateOrCreate(
                            ['clan_id' => $clanData['clan_id']],
                            [
                                'name' => $clanData['name'],
                                'tag' => $clanData['tag'],
                                'server' => strtoupper($server),
                            ]
                        );
                        Log::info("Stored clan with ID: " . $clanData['clan_id'] . " on server: " . strtoupper($server));
                    }

                    $page++;
                    $hasMore = count($clans['data']) === $limit;
                } else {
                    $hasMore = false;
                }
            }
        }

        return response()->json(['message' => 'Clans fetched and stored successfully'], 201);
    }
}
