<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\TrainingSet
 *
 * @property int $id
 * @property int $exercise_row_id
 * @property float|null $weight
 * @property float|null $weight_min
 * @property float|null $weight_max
 * @property int|null $reps
 * @property float|null $rpe
 * @property int|null $seconds
 * @property string|null $video
 * @property string|null $comment
 * @property int $is_realisation
 * @property int $completed
 * @property int|null $corresponding
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ExerciseRow $exerciseRow
 * @property-read TrainingSet|null $planning
 * @property-read TrainingSet|null $realisation
 * @method static \Database\Factories\TrainingSetFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSet query()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSet whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSet whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSet whereCorresponding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSet whereExerciseRowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSet whereIsRealisation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSet whereReps($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSet whereRpe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSet whereSeconds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSet whereVideo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSet whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSet whereWeightMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingSet whereWeightMin($value)
 * @mixin \Eloquent
 */
class TrainingSet extends Model
{
    use HasFactory;

    public $guarded = [];

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
