<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use App\Services\PlayerService;
use Illuminate\Support\Facades\Log;

class PlayerController extends Controller
{
    //index method made to display players

    protected $PlayerService;

    public function __construct(PlayerService $playerService)
    {
        $this->PlayerService = $playerService;
    }

    public function generateSearchTerms()
    {
        $terms = [];
        foreach (range('a', 'z') as $letter) {
            $terms[] = $letter;

            foreach (range('a', 'z') as $secondLetter) {
                $terms[] = $letter . $secondLetter;


                foreach (range('a', 'z') as $thirdLetter) {
                    $terms[] = $letter . $secondLetter . $thirdLetter;
                }
            }
        }
        return $terms;
    }

    public function fetchAndStorePlayers(Request $request)
    {
        Log::info("Reached fetchAndStorePlayers");

        $servers = ['eu', 'na', 'asia'];
        $searchTerms = $this->generateSearchTerms();

        foreach ($servers as $server) {
            foreach ($searchTerms as $search) {
                // Fetch and store players for each search term
                $players = $this->PlayerService->getAllPlayers($server, $search);

                if ($players) {
                    foreach ($players as $playerData) {
                        Player::updateOrCreate(
                            ['account_id' => $playerData['account_id']],
                            [
                                'nickname' => $playerData['nickname'],
                                'server' => strtoupper($server),
                            ]
                        );
                        Log::info("Stored player with ID: " . $playerData['account_id'] . " on server: " . strtoupper($server));
                    }
                }

                // Introduce a short delay to respect API rate limits
                usleep(500000); // 0.5 seconds
            }
        }

        return response()->json(['message' => 'All players fetched and stored in database successfully'], 201);
    }


    public function index()
    {
        $players = Player::all();

        return response()->json($players);
    }

    public function show($id)
    {
        $player = Player::findOrFail($id);
        return response()->json($player);
    }

    //save a player
    public function store(Request $request)
    {
        $validatedNewData = $request->validate([
            'nickname' => 'required|string|max:255',
            'server' => 'required|string|in:EU,NA,ASIA',
            'account_id' => 'required|integer|unique:players,account_id',
            'clan_id' => 'nullable|exists:clans,id',
        ]);


        $player = Player::create($validatedNewData);
        return response()->json($player, 201);
    }

    //update specific player's details
    public function update(Request $request, $id)
    {
        $player = Player::findOrFail($id);

        $validatedUpdateData = $request->validate([
            'nickname' => 'required|string|max:255',
            'server' => 'required|string|in:EU,NA,ASIA',
            'account_id' => 'required|integer|unique:players,account_id' . $id,
            'clan_id' => 'nullable|exists:clans,id',
        ]);

        $player->update($validatedUpdateData);

        return response()->json($player);
    }

    //delete a player

    public function destroy($id)
    {
        $player = Player::findOrFail($id);
        $player->delete();

        return response()->json(['message' => 'Player deleted succesfully from records.']);
    }
}
