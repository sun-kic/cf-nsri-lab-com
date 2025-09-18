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
        Schema::create('todays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('work_office')->nullable();
            $table->string('work_soho')->nullable();
            $table->string('work_3pl')->nullable();
            $table->string('life')->nullable();
            $table->string('move')->nullable();
            $table->bigInteger('office_area')->nullable()->default(0);
            $table->bigInteger('office_person')->nullable()->default(0);
            $table->string('three_pl_type')->nullable();
            $table->string('three_pl_city')->nullable();
            $table->bigInteger('light_time_office')->nullable()->default(0);
            $table->bigInteger('light_led_office')->nullable()->default(0);
            $table->bigInteger('light_time_soho')->nullable()->default(0);
            $table->bigInteger('light_led_soho')->nullable()->default(0);
            $table->bigInteger('light_time_3pl')->nullable()->default(0);
            $table->bigInteger('light_led_3pl')->nullable()->default(0);
            $table->bigInteger('ac_time_office')->nullable()->default(0);
            $table->bigInteger('ac_time_soho')->nullable()->default(0);
            $table->bigInteger('ac_time_3pl')->nullable()->default(0);
            $table->bigInteger('printed_paper')->nullable()->default(0);
            $table->bigInteger('pc_time')->nullable()->default(0);
            $table->string('drink_cup_type')->nullable();
            $table->bigInteger('move_floor_number')->nullable()->default(0);
            $table->bigInteger('move_walk')->nullable()->default(0);
            $table->bigInteger('move_out_number')->nullable()->default(0);
            $table->string('move_out_departure1')->nullable();
            $table->string('move_out_arrival1')->nullable();
            $table->string('move_out_type1')->nullable();
            $table->string('move_out_departure2')->nullable();
            $table->string('move_out_arrival2')->nullable();
            $table->string('move_out_type2')->nullable();
            $table->string('move_out_departure3')->nullable();
            $table->string('move_out_arrival3')->nullable();
            $table->string('move_out_type3')->nullable();
            $table->string('move_out_departure4')->nullable();
            $table->string('move_out_arrival4')->nullable();
            $table->string('move_out_type4')->nullable();
            $table->string('breakfast_image')->nullable();
            $table->string('breakfast_place')->nullable();
            $table->string('breakfast_type')->nullable();
            $table->string('breakfast_volumn')->nullable();
            $table->string('breakfast_vegetable_volumn')->nullable();
            $table->string('breakfast_vegetable_type')->nullable();
            $table->string('breakfast_vegetable_produced')->nullable();
            $table->string('breakfast_main_volumn')->nullable();
            $table->string('breakfast_main_type')->nullable();
            $table->string('breakfast_main_produced')->nullable();
            $table->string('lunch_image')->nullable();
            $table->string('lunch_place')->nullable();
            $table->string('lunch_type')->nullable();
            $table->string('lunch_volumn')->nullable();
            $table->string('lunch_vegetable_volumn')->nullable();
            $table->string('lunch_vegetable_type')->nullable();
            $table->string('lunch_vegetable_produced')->nullable();
            $table->string('lunch_main_volumn')->nullable();
            $table->string('lunch_main_type')->nullable();
            $table->string('lunch_main_produced')->nullable();
            $table->string('dinner_image')->nullable();
            $table->string('dinner_place')->nullable();
            $table->string('dinner_type')->nullable();
            $table->string('dinner_volumn')->nullable();
            $table->string('dinner_vegetable_volumn')->nullable();
            $table->string('dinner_vegetable_type')->nullable();
            $table->string('dinner_vegetable_produced')->nullable();
            $table->string('dinner_main_volumn')->nullable();
            $table->string('dinner_main_type')->nullable();
            $table->string('dinner_main_produced')->nullable();
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
        Schema::dropIfExists('todays');
    }
};
