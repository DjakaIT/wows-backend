<?php

namespace App\Http\Controllers;

use App\Models\PlayerShip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlayerShipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $playerShips = PlayerShip::with(['player', 'ship'])->paginate(15);
        return response()->json($playerShips);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_id' => 'required|exists:players,id',
            'ship_id' => 'required|exists:ships,id',
            'battles_played' => 'required|integer',
            'wins_count' => 'required|integer',
            'damage_dealt' => 'required|integer',
            'frags' => 'required|integer',
            'survival_rate' => 'required|numeric|between:0,100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $playerShip = PlayerShip::create($request->all());
        $playerShip->average_damage = $playerShip->averageDamage();
        $playerShip->save();

        return response()->json($playerShip, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $playerShip = PlayerShip::with(['player', 'ship'])->find($id);

        if (!$playerShip) {
            return response()->json(['message' => 'Player Ship not found'], 404);
        }

        return response()->json($playerShip);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $playerShip = PlayerShip::find($id);

        if (!$playerShip) {
            return response()->json(['message' => 'Player Ship not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'player_id' => 'exists:players,id',
            'ship_id' => 'exists:ships,id',
            'battles_played' => 'integer',
            'wins_count' => 'integer',
            'damage_dealt' => 'integer',
            'frags' => 'integer',
            'survival_rate' => 'numeric|between:0,100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $playerShip->update($request->all());
        $playerShip->average_damage = $playerShip->averageDamage();
        $playerShip->save();

        return response()->json($playerShip);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $playerShip = PlayerShip::find($id);

        if (!$playerShip) {
            return response()->json(['message' => 'Player Ship not found'], 404);
        }

        $playerShip->delete();
        return response()->json(['message' => 'Player Ship deleted successfully']);
    }
}
