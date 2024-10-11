<?php

namespace App\Http\Controllers;

use App\Models\ClanMember;
use Illuminate\Http\Request;

class ClanMemberController extends Controller
{

    public function index()
    {
        $clanMember = ClanMember::all();
        return response()->json($clanMember);
    }

    public function show($id)
    {
        $clanMember = ClanMember::findOrFail($id);
        return response()->json($clanMember);
    }

    public function store(Request $request)
    {

        $validateNewData = $request->validate([
            'players_id' => 'required|integer|unique:players, player_id',
            'clans_id' => 'required|integer|unique:clans, clan_id',
            'joined_at' => 'required|datetime',
            'left_at' => 'required|datetime',
            'role' => 'required|string|in:member,officer,leader'
        ]);

        $clanMember = ClanMember::create($validateNewData);
        return response()->json($clanMember, 201);
    }

    public function update(Request $request, $id)
    {
        $clanMember = ClanMember::findOrFail($id);

        $validateUpdateData = $request->validate([
            'players_id' => 'required|integer|unique:players, player_id',
            'clans_id' => 'required|integer|unique:clans, clan_id',
            'joined_at' => 'required|datetime',
            'left_at' => 'required|datetime',
            'role' => 'required|string|in:member,officer,leader'
        ]);


        $clanMember->update($validateUpdateData);
        return response()->json($clanMember);
    }
}
