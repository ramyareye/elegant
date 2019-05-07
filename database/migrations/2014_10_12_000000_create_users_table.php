<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->index()->unique();
            $table->string('name', 255);
            $table->string('family', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->boolean('email_verified')->default(false);
            $table->string('mobile')->unique()->nullable();
            $table->boolean('is_mobile_verified')->default(false);
            $table->boolean('is_charity')->default(false);
            $table->date('birthdate')->nullable();
            $table->enum('gender', ['man', 'woman', 'other'])->default('man');
            $table->string('password');
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('active')->default(false);

            $table->bigInteger('location_id')->unsigned()->nullable();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
