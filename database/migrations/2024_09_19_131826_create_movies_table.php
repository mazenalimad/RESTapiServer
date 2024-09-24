<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('name');
            $table->integer('released_at');
            $table->string('poster_url');
            $table->text('synopsis');
            $table->smallInteger('duration');
            $table->string('trailer_url')->nullable();
            $table->decimal('average_rating');
            $table->timestamp('crawled_at')->useCurrent();
            $table->string('url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
};
