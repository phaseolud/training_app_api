<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingDay extends Model
{
    use HasFactory;


    public function trainingPeriod(): BelongsTo
    {
        return $this->belongsTo(TrainingPeriod::class);
    }

    public function exerciseRows(): HasMany
    {
        return $this->hasMany(ExerciseRow::class);
    }
}
