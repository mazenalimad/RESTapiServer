<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class languages extends Model
{
    use HasFactory;

    public function movieslanguage () {
        return $this->belongsToMany(movies::class,'movie_languages', 'language_id', 'movie_id');
    }
}
