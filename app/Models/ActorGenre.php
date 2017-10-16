<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActorGenre extends Model
{
	public $table = 'actor_genres';

	public $fillable = [
		'actor_id',
		'genre_id'
	];

	/* Relationships */
	public function actors()
	{
		return $this->belongsTo(\App\Models\Actor::class, 'actor_id', 'id');
	}

	public function genres()
	{
		return $this->belongsTo(\App\Models\Genre::class, 'genre_id', 'id');
	}
}
