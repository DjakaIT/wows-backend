<?php

namespace App\Http\Controllers;

use App\Models\BattleParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BattleParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $battleParticipants = BattleParticipant::with(['player', 'ship', 'battle'])->paginate(15);
        return response()->json($battleParticipants);
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
            'battle_id' => 'required|exists:battles,id',
            'ship_id' => 'required|exists:ships,id',
            'duration' => 'required|integer',
            'team' => 'required|in:A,B',
            'victory' => 'required|boolean',
            'damage_dealt' => 'required|integer',
            'frags' => 'required|integer',
            'xp_earned' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $battleParticipant = BattleParticipant::create($request->all());
        return response()->json($battleParticipant, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $battleParticipant = BattleParticipant::with(['player', 'ship', 'battle'])->find($id);

        if (!$battleParticipant) {
            return response()->json(['message' => 'Battle Participant not found'], 404);
        }

        return response()->json($battleParticipant);
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
        $battleParticipant = BattleParticipant::find($id);

        if (!$battleParticipant) {
            return response()->json(['message' => 'Battle Participant not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'player_id' => 'exists:players,id',
            'battle_id' => 'exists:battles,id',
            'ship_id' => 'exists:ships,id',
            'duration' => 'integer',
            'team' => 'in:A,B',
            'victory' => 'boolean',
            'damage_dealt' => 'integer',
            'frags' => 'integer',
            'xp_earned' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $battleParticipant->update($request->all());
        return response()->json($battleParticipant);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $battleParticipant = BattleParticipant::find($id);

        if (!$battleParticipant) {
            return response()->json(['message' => 'Battle Participant not found'], 404);
        }

        $battleParticipant->delete();
        return response()->json(['message' => 'Battle Participant deleted successfully']);
    }
}
