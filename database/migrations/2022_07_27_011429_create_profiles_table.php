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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('prefecture');
            $table->string('sex');
            $table->string('age');
            $table->string('house_type');
            $table->bigInteger('house_build_year');
            $table->bigInteger('house_area');
            $table->date('year_month')->nullable();
            $table->string('power_company')->nullable();
            $table->bigInteger('power_amount')->nullable();
            $table->bigInteger('power_kw')->nullable();
            $table->string('gas_type')->nullable();
            $table->bigInteger('gas_amount')->nullable();
            $table->bigInteger('gas_m')->nullable();
            $table->bigInteger('kerosine_amount')->nullable();
            $table->bigInteger('kerosine_l')->nullable();

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
        Schema::dropIfExists('profiles');
    }
};
