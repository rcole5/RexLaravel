<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActorGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actor_genres', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('actor_id')->unsigned();
            $table->integer('genre_id')->unsigned();
            $table->timestamps();
            $table->foreign('actor_id')
                ->references('id')->on('actors')
                ->onDelete('cascade');
            $table->foreign('genre_id')
                ->references('id')->on('genres')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actor_genres');
    }
}
