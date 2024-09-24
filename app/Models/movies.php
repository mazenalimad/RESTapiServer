<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class movies extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',        // Movie title
        'released_at',
        'poster_url',
        'synopsis',
        'duration',
        'trailer_url',
        'average_rating',
        'url'
        // Add any other fields you want to allow for mass assignment
    ];


    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorite', 'movie_id', 'user_id');
    }

    public function languages(){
        return $this->belongsToMany(languages::class,'movie_languages','movie_id','language_id');
    }

    public function genres (){
        return $this->belongsToMany(genres::class,'movie_genres','movie_id','genre_id');
    }

    public function domains (){
        return $this->belongsToMany(domains::class,'movie_domains','movie_id','domain_id');
    }

    public function directors (){
        return $this->belongsToMany( directors::class,'movie_directors','movie_id', 'director_id');
    }

    public function cast_members (){
        return $this->belongsToMany(cast_members::class,'movie_cast', 'movie_id', 'cast_id');
    }
}
