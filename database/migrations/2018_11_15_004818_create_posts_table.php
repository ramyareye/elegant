<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title', 255);
            $table->string('slug', 255)->nullable();
            $table->string('keywords', 500)->nullable();
            $table->text('description')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();
            $table->boolean('visible')->default(false);

            $table->bigInteger('writer_id')->unsigned()->nullable();
            $table->foreign('writer_id')->references('id')->on('users')->onDelete('cascade');

            $table->softDeletes();
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
        Schema::dropIfExists('posts');
    }
}
