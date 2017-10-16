<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    public $table = 'actors';

    public $fillable = [
    	'name',
    	'dob',
    	'age',
    	'bio',
    	'image'
    ];

    /* Relationships */
    public function movies()
    {
    	// return $this->belongsToMany(\App\Models\Movie::class, 'actor_movies', 'actor_id', 'movie_id');
    	return $this->hasMany(\App\Models\Actor::class,
          'actor_id', 'id');
    }

    public function genres()
    {
    	return $this->belongsToMany(\App\Models\Genre::class, 'actor_genres', 'actor_id', 'genre_id');
    }
}
