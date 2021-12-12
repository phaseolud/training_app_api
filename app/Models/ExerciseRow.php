<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ExerciseRow
 *
 * @property int $id
 * @property string $comments
 * @property int $training_day_id
 * @property int $exercise_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Exercise $exercise
 * @property-read \App\Models\TrainingDay $trainingDay
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TrainingSet[] $trainingSets
 * @property-read int|null $training_sets_count
 * @method static \Database\Factories\ExerciseRowFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseRow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseRow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseRow query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseRow whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseRow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseRow whereExerciseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseRow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseRow whereTrainingDayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExerciseRow whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ExerciseRow extends Model
{
    use HasFactory;

    public $guarded = [];

    public function trainingDay(): BelongsTo
    {
        return $this->belongsTo(TrainingDay::class);
    }

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }

    public function trainingSets(): HasMany
    {
        return $this->hasMany(TrainingSet::class);
    }
}
