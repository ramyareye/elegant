<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignOwnerPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_owner', function (Blueprint $table) {
            $table->bigInteger('campaign_id')->unsigned()->index();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->bigInteger('owner_id')->unsigned()->index();
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->primary(['campaign_id', 'owner_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('campaign_owner');
    }
}
