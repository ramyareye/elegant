<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Kalnoy\Nestedset\NestedSet;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('old_id')->unsigned()->nullable();
            $table->uuid('uuid')->index()->unique();

            $table->string('name');
            $table->string('slug');
            $table->string('link')->nullable();            
            $table->text('keywords')->nullable();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('menu')->default(false);
            $table->boolean('visible')->default(true);
            $table->date('published_at')->nullable();
            
            NestedSet::columns($table);

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('categorizables', function (Blueprint $table) {
            $table->integer('category_id')->unsigned();
            $table->integer('categorizable_id')->unsigned();
            $table->string('categorizable_type');

            // $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {        
        Schema::dropIfExists('categorizables');
        Schema::dropIfExists('categories');
    }
}
