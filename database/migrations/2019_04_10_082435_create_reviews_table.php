<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->enum('rate', [1, 2, 3, 4, 5]);
            $table->string('comment', 500)->nullable();
            $table->enum('status', ['publish', 'pending', 'reject'])->default('pending');       

            $table->bigInteger('reviewed_by')->unsigned()->index();
            $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('reply_to')->unsigned()->index()->nullable();
            $table->foreign('reply_to')->references('id')->on('reviews')->onDelete('cascade');            

            $table->bigInteger('managed_by')->unsigned()->index()->nullable();
            $table->foreign('managed_by')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('reviews');
    }
}
