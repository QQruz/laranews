<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('laranews.tables.request'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('auto_update')->default(false);
            $table->string('name')->unique();
            $table->string('endpoint');
            $table->string('category')->nullable();
            $table->string('country')->nullable();
            $table->string('domains')->nullable();
            $table->string('excludeDomains')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('language')->nullable();
            $table->string('pageSize')->nullable();
            $table->string('page')->nullable();
            $table->string('q')->nullable();
            $table->string('qInTitle')->nullable();
            $table->string('sources')->nullable();
            $table->string('sortBy')->nullable();
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
        Schema::dropIfExists('requests');
    }
}
