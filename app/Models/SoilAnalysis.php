<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoilAnalysis extends Model
{
    protected $fillable = [
        'farm_id', 'target_crop', 'ph', 'fertility', 'moisture', 'temperature', 
        'sunlight', 'humidity', 'analysis_date', 'status'
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function recommendation()
    {
        return $this->hasOne(Recommendation::class);
    }
}
