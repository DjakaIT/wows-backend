<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use Illuminate\Http\Request;

class ClanController extends Controller
{
    public function index()
    {
        $clans = Clan::all();
        return response()->json($clans);
    }

    public function showClan($id)

    {
        $clan = Clan::findOrFail($id);
        return response()->json($clan);
    }

    public function store(Request $request)
    {
        $validateClanData = ([
            'name' => 'required|string|max:255',
            'tag' => 'required|string|max:15',
            'server' => 'required|string|in:EU,NA,ASIA',
            'clan_id' => 'required|integer|unique|clan, clan_id'
        ]);

        $clan = Clan::create($validateClanData);
        return response()->json($clan, 201);
    }

    public function update(Request $request, $id)
    {

        $clan = Clan::findOrFail($id);

        $validateUpdatedClanData = ([
            'name' => 'required|string|max:255',
            'tag' => 'required|string|max:15',
            'server' => 'required|string|in:EU,NA,ASIA',
            'clan_id' => 'required|integer|unique|clan, clan_id' . $id
        ]);

        $clan->update($validateUpdatedClanData);
        return response()->json($clan);
    }


    public function destroy($id)
    {
        $clan = Clan::findOrFail($id);
        $clan->delete();
        return response()->json(['message' => 'Clan succesfully deleted from records']);
    }
}
