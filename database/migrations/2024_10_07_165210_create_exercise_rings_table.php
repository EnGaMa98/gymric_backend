<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('exercise_rings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('move_goal');
            $table->integer('move_progress');
            $table->integer('exercise_goal');
            $table->integer('exercise_progress');
            $table->integer('stand_goal');
            $table->integer('stand_progress');
            $table->date('date'); // Guardar la fecha de cada entrada
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_rings');
    }
};
