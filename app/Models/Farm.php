<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    protected $fillable = ['user_id', 'name', 'location', 'size', 'soil_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function soilAnalyses()
    {
        return $this->hasMany(SoilAnalysis::class);
    }
}
