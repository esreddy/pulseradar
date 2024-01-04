<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Assembly;
use App\Models\Parliament;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function showStates()
    {
        $states = State::all();

        return view('states')->with('states', $states);
    }

    public function getConstituencies($stateId)
    {
        $type=2;
        if ($type == 1) {
            $results = Parliament::select('id', 'name')
                ->where('stateId', $stateId)
                ->where('status', 1)
                ->orderBy('id', 'ASC')
                ->get();
        }
        if ($type == 2) {
            $results = Assembly::select('assemblies.name', 'assemblies.id')
                ->join('parliaments', 'parliaments.id', '=', 'assemblies.parliamentId')
                ->where('parliaments.stateId', $stateId)
                ->get();
        }
        $constituencies=$results;
        return response()->json($constituencies);
    }
}
