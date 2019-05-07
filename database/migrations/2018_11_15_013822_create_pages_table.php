<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title', 255);
            $table->string('slug', 255)->nullable();
            $table->string('excerpt')->nullable();
            $table->text('body')->nullable();
            $table->boolean('visible')->default(false);
            $table->boolean('children')->default(false);
            $table->string('keywords', 500)->nullable();
            $table->text('description')->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->bigInteger('writer_id')->unsigned()->nullable();
            
            $table->enum('sidebar', 
                ['disable', 'default']
            )->default('disable');
                        
            $table->enum('type', [
                'default'
            ])->default('default');            

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('writer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
