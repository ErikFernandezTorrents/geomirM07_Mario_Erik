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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('body');
            $table->unsignedBigInteger('file_id');
            $table->string('latitude');
            $table->string('longitude');
            //$table->integer('visibility_id');
            $table->unsignedBigInteger('author_id');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->foreign('author_id')->references('id')->on('users');
            $table->foreign('file_id')->references('id')->on('files');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
