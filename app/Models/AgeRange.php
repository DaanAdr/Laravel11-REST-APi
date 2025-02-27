<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgeRange extends Model
{
    protected $fillable = ['age_range'];

    protected $hidden = ['created_at', 'updated_at'];
}
