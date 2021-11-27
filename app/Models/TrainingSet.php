<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TrainingSet extends Model
{
    use HasFactory;

    public function exerciseRow() : BelongsTo
    {
        return $this->belongsTo(ExerciseRow::class);
    }

    public function realisation() : HasOne
    {
        return $this->hasOne(TrainingSet::class, 'corresponding');
    }

    public function planning() : HasOne
    {
        return $this->hasOne(TrainingSet::class, 'corresponding');
    }
}
