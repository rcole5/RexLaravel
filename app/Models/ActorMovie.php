<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActorMovie extends Model
{
	public $table = 'actor_movies';

	public $fillable = [
		'actor_id',
		'genre_id',
		'character_name'
	];

	/* Relationships */
	public function actors()
	{
		return $this->belongsTo(\App\Models\Actor::class, 'actor_id', 'id');
	}

	public function movies()
	{
		return $this->belongsTo(\App\Models\Movie::class, 'movie_id', 'id');
	}
}
