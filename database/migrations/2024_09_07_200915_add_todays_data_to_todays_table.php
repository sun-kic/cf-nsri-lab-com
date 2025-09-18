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
            $table->float('works_carbon')->nullable();
            $table->float('foods_carbon')->nullable();
            $table->float('move_carbon')->nullable();
            $table->float('life_carbon')->nullable();
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
