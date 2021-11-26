<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{
    use HasFactory;

    protected $casts = [
        'muscle_groups' => AsCollection::class
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Exercise::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Exercise::class, 'parent_id');
    }
}
