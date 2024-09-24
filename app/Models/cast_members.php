<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cast_members extends Model
{
    use HasFactory;

    public function moviesCastMembers () {
        return $this->belongsToMany(cast_members::class,'movie_cast', 'cast_id', 'movie_id');
    }
}
