<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\WowsApiService;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Clan;

class FetchClansJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $region;

    public function __construct($region)
    {
        $this->region = $region;
    }

    public function handle(WowsApiService $wowsApiService)
    {
        $clans = $wowsApiService->getClans($this->region);

        foreach ($clans as $clanData) {
            Clan::updateOrCreate(
                ['clan_id' => $clanData['clan_id']],
                [
                    'name' => $clanData['name'],
                    'tag' => $clanData['tag'],
                    'server' => $this->region,
                ]
            );
        }
    }
}
