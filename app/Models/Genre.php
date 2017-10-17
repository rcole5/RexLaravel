<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
	public $table = 'genres';

	public $fillable = [
		'name'
	];

	public function movies()
	{
//		return $this->belongsToMany(\App\Models\MovieGenre::class, 'movie_id');
		return $this->belongsToMany(\App\Models\Movie::class,
        'movie_genres',
        'genre_id',
        'movie_id');
	}

	public function actors()
	{
		return $this->belongsToMany(\App\Models\Actor::class,
        'actor_genres',
        'genre_id',
        'actor_id');
	}
}
