<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_row_id')->constrained();

            $table->float('weight')->nullable();
            $table->float('weight_min')->nullable();
            $table->float('weight_max')->nullable();

            # used for the set order
            $table->integer('index');

            $table->integer('reps')->nullable();
            $table->integer('reps_min')->nullable();
            $table->integer('reps_max')->nullable();

            $table->float('rpe')->nullable();
            $table->integer('seconds')->nullable();
            $table->string('video')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('amrap')->default(false);

            $table->boolean('is_realisation');
            $table->boolean('completed');
            $table->integer('corresponding')->nullable();
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
        Schema::dropIfExists('training_sets');
    }
}
