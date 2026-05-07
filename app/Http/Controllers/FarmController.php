<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FarmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $farms = auth()->user()->farms()->withCount('soilAnalyses')->get();
        return view('farms.index', compact('farms'));
    }

    public function create()
    {
        return view('farms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'size' => 'nullable|numeric|min:0',
            'soil_type' => 'nullable|string|max:255',
        ]);

        auth()->user()->farms()->create($validated);

        return redirect()->route('farms.index')->with('success', 'Farm created successfully!');
    }

    public function show($id)
    {
        $farm = auth()->user()->farms()->with('soilAnalyses')->findOrFail($id);
        return view('farms.show', compact('farm'));
    }

    public function edit($id)
    {
        $farm = auth()->user()->farms()->findOrFail($id);
        return view('farms.edit', compact('farm'));
    }

    public function update(Request $request, $id)
    {
        $farm = auth()->user()->farms()->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'size' => 'nullable|numeric|min:0',
            'soil_type' => 'nullable|string|max:255',
        ]);

        $farm->update($validated);

        return redirect()->route('farms.index')->with('success', 'Farm updated successfully!');
    }

    public function destroy($id)
    {
        $farm = auth()->user()->farms()->findOrFail($id);
        $farm->delete();

        return redirect()->route('farms.index')->with('success', 'Farm deleted successfully!');
    }
}
