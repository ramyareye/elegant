<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBenefitingCampaignPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benefiting_campaign', function (Blueprint $table) {
            $table->bigInteger('benefiting_id')->unsigned()->index();
            $table->foreign('benefiting_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('campaign_id')->unsigned()->index();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->primary(['benefiting_id', 'campaign_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('benefiting_campaign');
    }
}
