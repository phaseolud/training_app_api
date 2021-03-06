<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_days', function (Blueprint $table) {
            $table->id();
            $table->integer('index');
            $table->string('name')->nullable();
            $table->date('date')->nullable();
            $table->boolean('completed');
            $table->foreignId('training_period_id')->constrained();
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
        Schema::dropIfExists('training_days');
    }
}
