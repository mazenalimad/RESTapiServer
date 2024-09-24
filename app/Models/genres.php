<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class genres extends Model
{
    use HasFactory;

    public function moviesgenres () {
        return $this->belongsToMany(genres::class,'movie_genres', 'genre_id', 'movie_id');
    }
}
