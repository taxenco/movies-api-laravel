<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the `movies` table with columns `id`, `title`, `release_year`, `genres`, `description`, and `timestamps`
        Schema::create('movies', function (Blueprint $table) {
            $table->id(); // Creates an auto-incrementing primary key column
            $table->string('title'); // Creates a string column for the title of the movie
            $table->unsignedSmallInteger('release_year'); // Creates an unsigned small integer column for the year of release
            $table->string('genres'); // Creates a string column for the genres of the movie
            $table->text('description')->nullable(); // Creates a nullable text column for the description of the movie
            $table->timestamps(); // Creates `created_at` and `updated_at` timestamp columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the `movies` table if it exists
        Schema::dropIfExists('movies');
    }
}
