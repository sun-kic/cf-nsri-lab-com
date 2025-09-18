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
        Schema::create('carbonsums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->float('works_carbon')->nullable();
            $table->float('foods_carbon')->nullable();
            $table->float('move_carbon')->nullable();
            $table->float('life_carbon')->nullable();
            $table->float('accumulated_works_carbon')->nullable();
            $table->float('accumulated_foods_carbon')->nullable();
            $table->float('accumulated_move_carbon')->nullable();
            $table->float('accumulated_life_carbon')->nullable();
            $table->float('accumulated_total_carbon')->nullable();
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
        Schema::dropIfExists('carbonsums');
    }
};
