<?php

namespace App\Http\Controllers;

use App\Models\ClanMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClanMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ClanMember::with(['player', 'clan']);

        if ($request->has('active') && $request->active == 'true') {
            $query->byActive();
        }

        $clanMembers = $query->paginate(15);
        return response()->json($clanMembers);
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
            'players_id' => 'required|exists:players,id',
            'clans_id' => 'required|exists:clans,id',
            'joined_at' => 'required|date',
            'left_at' => 'nullable|date|after:joined_at',
            'role' => 'required|in:member,officer,leader',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $clanMember = ClanMember::create($request->all());
        return response()->json($clanMember, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clanMember = ClanMember::with(['player', 'clan'])->find($id);

        if (!$clanMember) {
            return response()->json(['message' => 'Clan Member not found'], 404);
        }

        return response()->json($clanMember);
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
        $clanMember = ClanMember::find($id);

        if (!$clanMember) {
            return response()->json(['message' => 'Clan Member not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'players_id' => 'exists:players,id',
            'clans_id' => 'exists:clans,id',
            'joined_at' => 'date',
            'left_at' => 'nullable|date|after:joined_at',
            'role' => 'in:member,officer,leader',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $clanMember->update($request->all());
        return response()->json($clanMember);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $clanMember = ClanMember::find($id);

        if (!$clanMember) {
            return response()->json(['message' => 'Clan Member not found'], 404);
        }

        $clanMember->delete();
        return response()->json(['message' => 'Clan Member deleted successfully']);
    }
}
