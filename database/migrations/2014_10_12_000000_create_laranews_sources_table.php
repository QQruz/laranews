<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaranewsSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('laranews.tables.source'), function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('name');
            $table->text('description');
            $table->text('url');
            $table->string('category');
            $table->string('country');
            $table->string('language');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('laranews.sourcesTable'));
    }
}
