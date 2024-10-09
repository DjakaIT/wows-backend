<?php

namespace App\Http\Controllers;

use App\Models\Ship;
use Illuminate\Http\Request;

class ShipController extends Controller
{
    //display all ships

    public function index()
    {
        $ships = Ship::all();
        return response()->json($ships);
    }

    //display particular ships
    public function show($id)
    {
        $ships = Ship::findOrFail($id);
        return response()->json($ships);
    }

    //save a ship
    public function store(Request $request)
    {

        $validatedShipData = $request->validate([
            'name' => 'required|string|max:150',
            'tier' => 'required|integer',
            'type' => 'required|integer',
            'nation' => 'required|string|max:80',
            'ship_id' => 'required|unique:ships, ship_id'
        ]);

        $ship = Ship::create($validatedShipData);
        return response()->json($ship, 201);
    }

    public function update(Request $request, $id)
    {
        $ship = Ship::findOrFail($id);

        $validatedUpdatedShipData = $request->validate([
            'name' => 'required|string|max:150',
            'tier' => 'required|integer',
            'type' => 'required|integer',
            'nation' => 'required|string|max:80',
            'ship_id' => 'required|unique:ships, ship_id'
        ]);


        $ship->update($validatedUpdatedShipData);
        return response()->json($ship);
    }

    //delete a ship

    public function destroy($id)
    {
        $ship = Ship::findOrFail($id);
        $ship->delete();

        return response()->json(['message' => 'Ship deleted succesfully from records']);
    }
}
