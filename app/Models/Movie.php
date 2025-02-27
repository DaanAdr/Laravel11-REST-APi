<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    protected $fillable = ['name', 'age_range_id'];

    protected $hidden = ['created_at', 'updated_at', 'age_range_id'];

    public function age_range(): BelongsTo
    {
        return $this->belongsTo(AgeRange::class);
    }

    public function actors(): BelongsToMany
    {
        return $this->belongsToMany(Actor::class, 'actor_movie');
    }
}
