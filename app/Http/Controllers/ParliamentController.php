<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Parliament;
use Illuminate\Http\Request;

class ParliamentController extends Controller
{
    public function index()
    {
        $parliaments = Parliament::all();
        return view('parliaments.index', compact('parliaments'));
    }
    public function create()
    {
        $states = State::all();
        return view('parliaments.create', compact('states'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'stateId' => 'required|exists:states,id',
            'name' => 'required|max:255',
        ]);

        Parliament::create($request->all());

        return redirect()->route('parliaments.index')->with('success', 'Parliament created successfully');
    }

    public function edit(Parliament $parliament)
    {
        $states = State::all();
        return view('parliaments.edit', compact('parliament', 'states'));
    }

    public function update(Request $request, Parliament $parliament)
    {
        $request->validate([
            'stateId' => 'required|exists:states,id',
            'name' => 'required|max:255',
        ]);

        $parliament->update($request->all());

        return redirect()->route('parliaments.index')->with('success', 'Parliament updated successfully');
    }
}
