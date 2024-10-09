<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    //index method made to display players

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
