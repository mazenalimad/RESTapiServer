<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class domains extends Model
{
    use HasFactory;

    public function moviesdomain () {
        return $this->belongsToMany(domains::class,'movie_domains', 'domain_id', 'movie_id');
    }
}
