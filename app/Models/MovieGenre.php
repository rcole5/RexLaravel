<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovieGenre extends Model
{
    public $table = 'movie_genres';

    public $fillable = [
    	'movie_id',
    	'genre_id'
    ];

    /* Relationships */
    public function movies()
    {
    	return $this->belongsTo(\App\Models\Movie::class,
          'movie_id', 'id');
    }

    public function genres()
    {
    	return $this->belongsTo(\App\Models\Genre::class,
          'genre_id', 'id');
    }
}
