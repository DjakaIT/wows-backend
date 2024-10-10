<?php

namespace App\Http\Controllers;

use App\Models\PlayerShip;
use Illuminate\Http\Request;

class PlayerShipController extends Controller
{

    public function index()
    {
        $playerShip = PlayerShip::all();
        return response()->json($playerShip);
    }

    public function show($id)
    {
        $playerShip = PlayerShip::findOrFail($id);
        return response()->json($playerShip);
    }

    public function store(Request $request)
    {
        $validatedNewStatData = $request->validate([
            'player_id' => 'required|exists:players,id',
            'battles_played' => 'required|integer',
            'wins' => 'required|integer',
            'damage_dealt' => 'required|integer',
            'avg_xp' => 'required|integer',
            'win_rate' => 'required|numeric',
            'wn8' => 'required|numeric',
        ]);


        $playerShip = PlayerShip::create($validatedNewStatData);
        return response()->json($playerShip, 201);
    }

    public function update(Request $request, $id)
    {

        $playerShip = PlayerShip::findOrFail($id);

        $validatedUpdatedStatData = $request->validate([
            'player_id' => 'required|exists:players,id',
            'battles_played' => 'required|integer',
            'wins' => 'required|integer',
            'damage_dealt' => 'required|integer',
            'avg_xp' => 'required|integer',
            'win_rate' => 'required|numeric',
            'wn8' => 'required|numeric',
        ]);


        $playerShip->update($validatedUpdatedStatData);
        return response()->json($playerShip);
    }

    public function destroy($id)
    {
        $playerShip = PlayerShip::findOrFail($id);
        $playerShip->delete();

        return response()->json(['message' => "Player's stats deleted succesfully from records."]);
    }
}
