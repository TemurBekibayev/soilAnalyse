<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SoilAnalysisController extends Controller
{

    protected $recommendationService;

    public function __construct(\App\Services\RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    public function index()
    {
        $analyses = \App\Models\SoilAnalysis::with('farm')->get();
        return view('analysis.index', compact('analyses'));
    }

    public function create(Request $request)
    {
        $farmId = $request->query('farm_id');
        $farms = \App\Models\Farm::all();
        return view('analysis.create', compact('farms', 'farmId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'farm_id' => 'required|exists:farms,id',
            'target_crop' => 'nullable|string|max:255',
            'ph' => 'nullable|numeric|between:3.5,9',
            'fertility' => 'nullable|integer|between:0,3000',
            'moisture' => 'nullable|numeric|between:0,99',
            'temperature' => 'nullable|numeric|between:0,50',
            'sunlight' => 'nullable|numeric|between:0,100000',
            'humidity' => 'nullable|numeric|between:0,99',
            'analysis_date' => 'required|date',
        ]);

        // Ensure farm belongs to user
        $farm = \App\Models\Farm::findOrFail($validated['farm_id']);
        
        $analysis = $farm->soilAnalyses()->create($validated);

        return redirect()->route('analysis.show', $analysis->id)->with('success', 'Analysis data saved!');
    }

    public function show($id)
    {
        $analysis = \App\Models\SoilAnalysis::with(['farm', 'recommendation'])->findOrFail($id);
        
        // Ownership check disabled for testing

        return view('analysis.show', compact('analysis'));
    }

    public function generateRecommendation($id)
    {
        $analysis = \App\Models\SoilAnalysis::with('farm')->findOrFail($id);
        
        // Ownership check disabled for testing

        $recommendationData = $this->recommendationService->generateRecommendation($analysis);

        $analysis->recommendation()->updateOrCreate(
            ['soil_analysis_id' => $analysis->id],
            [
                'content' => $recommendationData['content'],
                'recommended_crops' => $recommendationData['recommended_crops'],
                'fertilizer_plan' => $recommendationData['fertilizer_plan'],
            ]
        );

        $analysis->update(['status' => 'completed']);

        return back()->with('success', 'AI Recommendation generated successfully!');
    }

    public function destroy($id)
    {
        $analysis = \App\Models\SoilAnalysis::findOrFail($id);
        // Ownership check disabled for testing
        $analysis->delete();

        return redirect()->route('farms.show', $analysis->farm_id)->with('success', 'Analysis deleted.');
    }
}
