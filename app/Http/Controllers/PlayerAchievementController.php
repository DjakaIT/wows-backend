<?php

namespace App\Http\Controllers;

use App\Models\PlayerAchievement;
use Illuminate\Http\Request;


class PlayerAchievementController extends Controller
{
    public function index()
    {
        $playerAchievement = PlayerAchievement::all();
        return response()->json($playerAchievement);
    }

    public function show($id)
    {
        $playerAchievement = PlayerAchievement::findOrFail($id);
        return response()->json($playerAchievement);
    }

    public function store(Request $request)
    {
        $validatedNewAchievementData = $request->validate([
            'player_id' => 'required|exists:players,id',
            'achievement_id' => 'required|exists:achievements,id',
            'date_earned' => 'required|date',
        ]);


        $playerAchievement = PlayerAchievement::create($validatedNewAchievementData);
        return response()->json($playerAchievement, 201);
    }

    public function update(Request $request, $id)
    {

        $playerAchievement = PlayerAchievement::findOrFail($id);

        $validatedUpdatedAchievementData = $request->validate([
            'player_id' => 'required|exists:players,id',
            'achievement_id' => 'required|exists:achievements,id',
            'date_earned' => 'required|date',
        ]);


        $playerAchievement->update($validatedUpdatedAchievementData);
        return response()->json($playerAchievement);
    }

    public function destroy($id)
    {
        $playerAchievement = PlayerAchievement::findOrFail($id);
        $playerAchievement->delete();

        return response()->json(['message' => "Player's achievement deleted succesfully from records."]);
    }
}
