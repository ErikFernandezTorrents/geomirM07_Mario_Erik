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
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('descripcion');
            $table->integer('file_id');
            $table->string('latitude');
            $table->string('longitude');
            // $table->integer('category_id')->nullable;
            // $table->integer('visibility_id')->nullable;
            $table->unsignedBigInteger('author_id');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->foreign('author_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('places');
    }
};
