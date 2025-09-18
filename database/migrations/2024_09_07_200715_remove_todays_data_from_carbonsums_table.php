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
        Schema::table('carbonsums', function (Blueprint $table) {
            $table->dropColumn('works_carbon');
            $table->dropColumn('foods_carbon');
            $table->dropColumn('move_carbon');
            $table->dropColumn('life_carbon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carbonsums', function (Blueprint $table) {
            //
        });
    }
};
