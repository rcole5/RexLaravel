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
		return $this->hasMany(\App\Models\MovieGenre::class, 'movie_id');
	}

	public function actors()
	{
		return $this->hasMany(\App\Models\ActorGenre::class, 'actor_id');
	}
}
