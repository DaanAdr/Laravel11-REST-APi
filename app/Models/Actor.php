<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Actor extends Model
{
    protected $fillable = ['name'];

    protected $hidden = ['created_at', 'updated_at'];

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'actor_movie');
    }
}
