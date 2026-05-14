<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $farmsCount = $user->farms()->count();
        $analysesCount = $user->farms()->withCount('soilAnalyses')->get()->sum('soil_analyses_count');
        $recentAnalyses = \App\Models\SoilAnalysis::whereIn('farm_id', $user->farms()->pluck('id'))
            ->with('farm')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('farmsCount', 'analysesCount', 'recentAnalyses'));
    }
}
