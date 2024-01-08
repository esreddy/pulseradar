<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Assembly;
use Illuminate\Http\Request;

class AssemblyController extends Controller
{
    public function index()
    {
        $assemblies = Assembly::all();
        return view('assemblies.index', compact('assemblies'));
    }

    public function create()
    {
        $states = State::all();
        return view('assemblies.create', compact('states'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'stateId' => 'required|exists:states,id',
            'name' => 'required|max:255',
        ]);

        Assembly::create($request->all());

        return redirect()->route('assemblies.index')->with('success', 'Assembly created successfully');
    }

    public function edit(Assembly $assembly)
    {
        $states = State::all();
        return view('assemblies.edit', compact('assembly', 'states'));
    }

    public function update(Request $request, Assembly $assembly)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'name' => 'required|max:255',
        ]);

        $assembly->update($request->all());

        return redirect()->route('assemblies.index')->with('success', 'Assembly updated successfully');
    }

    public function destroy(Assembly $assembly)
    {
        $assembly->delete();

        return redirect()->route('assemblies.index')->with('success', 'Assembly deleted successfully');
    }


    public function getAssemblyInfo(Request $request)
    {
        $assemblyId = $request->input('assemblyId');

        // Fetch assembly information based on ID
        $assembly = Assembly::find($assemblyId);

        return response()->json($assembly);
    }
    public function updateAssemblyInfo(Request $request)
    {
        $assemblyId=$request->assemblyId;
        $assembly = Assembly::findOrFail($assemblyId);
        $assembly->name = $request->input('assemblyName');
        $assembly->update();
        //return response()->json($assembly);

        $successMessage = ['message' => 'Assembly information updated successfully'];

        return response()->json($successMessage);
    }
}
