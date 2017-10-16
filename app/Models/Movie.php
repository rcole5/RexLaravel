<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public $table = 'movies';

    public $fillable = [
        'title',
        'rating',
        'description',
        'image'
    ];


    /* Relationships */
    public function actors()
    {
        return $this->belongsToMany(\App\Models\Actor::class,
            'actor_movies', 'movie_id', 'actor_id')
            ->withPivot('character_name');
    }

    public function genres()
    {
        return $this->belongsToMany(\App\Models\Genre::class,
            'movie_genres', 'movie_id', 'genre_id');
    }
}
