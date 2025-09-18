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
        Schema::table('todays', function (Blueprint $table) {
            $table->bigInteger('sports_time')->nullable()->default(0);
            $table->string('sports_type')->nullable();
            $table->string('sports_place')->nullable();
            $table->bigInteger('rest_time')->nullable()->default(0);
            $table->string('rest_type')->nullable();
            $table->bigInteger('shopping_ce')->nullable()->default(0);
            $table->bigInteger('shopping_cloth')->nullable()->default(0);
            $table->bigInteger('shopping_hobby')->nullable()->default(0);
            $table->bigInteger('shopping_office')->nullable()->default(0);
            $table->bigInteger('shopping_daily')->nullable()->default(0);
            $table->bigInteger('shopping_tabacco')->nullable()->default(0);
            $table->bigInteger('shopping_other')->nullable()->default(0);
            $table->bigInteger('green_power')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('todays', function (Blueprint $table) {
            //
        });
    }
};
