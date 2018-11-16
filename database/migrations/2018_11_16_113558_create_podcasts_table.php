<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePodcastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('podcasts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('podcast_show_id');
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('duration');
            $table->string('published_at');
            $table->string('audio_url');
            $table->timestamps();

            $table->foreign('podcast_show_id')->references('id')->on('podcast_shows')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('podcasts');
    }
}
