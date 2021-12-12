<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\TrainingDay
 *
 * @property int $id
 * @property int $index
 * @property string|null $name
 * @property string|null $date
 * @property int $completed
 * @property int $training_period_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExerciseRow[] $exerciseRows
 * @property-read int|null $exercise_rows_count
 * @property-read \App\Models\TrainingPeriod $trainingPeriod
 * @method static \Database\Factories\TrainingDayFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingDay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingDay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingDay query()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingDay whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingDay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingDay whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingDay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingDay whereIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingDay whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingDay whereTrainingPeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingDay whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TrainingDay extends Model
{
    use HasFactory;

    public $guarded = [];

    public function trainingPeriod(): BelongsTo
    {
        return $this->belongsTo(TrainingPeriod::class);
    }

    public function exerciseRows(): HasMany
    {
        return $this->hasMany(ExerciseRow::class);
    }
}
