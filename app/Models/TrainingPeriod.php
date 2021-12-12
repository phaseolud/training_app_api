<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\TrainingPeriod
 *
 * @property int $id
 * @property string $start_date
 * @property int $n_days
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TrainingDay[] $trainingDays
 * @property-read int|null $training_days_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\TrainingPeriodFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingPeriod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingPeriod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingPeriod query()
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingPeriod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingPeriod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingPeriod whereNDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingPeriod whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingPeriod whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TrainingPeriod whereUserId($value)
 * @mixin \Eloquent
 */
class TrainingPeriod extends Model
{
    use HasFactory;

    protected $dates = [
        'start_date',
        'created_at',
        'updated_at'
    ];

    protected $guarded = [];

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = Carbon::createFromFormat('d-m-Y', $value);
    }

    public function trainingDays() : HasMany
    {
        return $this->hasMany(TrainingDay::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
