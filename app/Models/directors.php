<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class directors extends Model
{
    use HasFactory;

    public function moviesdirectors () {
        return $this->belongsToMany(directors::class,'movie_directors', 'director_id', 'movie_id');
    }
}
