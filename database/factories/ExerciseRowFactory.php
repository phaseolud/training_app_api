<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\TrainingDay;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class ExerciseRowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape(['training_day_id' =>  "int", 'exercise_id' => "int", 'comments' => "string"])] public function definition()
    {
        return [
            'training_day_id' => TrainingDay::factory(),
            'exercise_id' => Exercise::factory(),
            'comments' => $this->faker->paragraph()
        ];
    }
}
