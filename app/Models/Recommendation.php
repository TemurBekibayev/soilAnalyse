<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $fillable = [
        'soil_analysis_id', 'content', 'recommended_crops', 'fertilizer_plan'
    ];

    protected $casts = [
        'recommended_crops' => 'array',
        'fertilizer_plan' => 'array',
    ];

    public function soilAnalysis()
    {
        return $this->belongsTo(SoilAnalysis::class);
    }
}
