<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (!auth()->check()) {
        $user = \App\Models\User::first();
        if ($user) {
            auth()->login($user);
        }
    }
    return redirect()->route('dashboard');
});

Route::group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('farms', \App\Http\Controllers\FarmController::class);
    
    Route::resource('analysis', \App\Http\Controllers\SoilAnalysisController::class);
    Route::post('analysis/{id}/recommend', [\App\Http\Controllers\SoilAnalysisController::class, 'generateRecommendation'])->name('analysis.recommend');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
