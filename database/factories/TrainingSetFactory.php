<?php

namespace Database\Factories;

use App\Models\ExerciseRow;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrainingSetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $is_realisation = $this->faker->boolean();
        $is_realisation_attributes = [
            'rpe' => $this->faker->randomDigit(),
            'video' => $this->faker->uuid(),
            'comment' => $this->faker->words(5,true),
        ];

        $is_weight = $this->faker->boolean();

        $is_weight_attributes =  [
            'weight' => $this->faker->randomFloat(1,20,100),
            'weight_min' => $this->faker->boolean() ? $this->faker->randomFloat(1,20,100) : null,
            'weight_max' => $this->faker->boolean() ? $this->faker->randomFloat(1,20,100) : null,
        ];

        $is_reps = $this->faker->boolean();
        $is_time = !$is_reps;

        $is_reps_attributes = [
          'reps' => $this->faker->randomDigitNotNull()
        ];

        $is_time_attributes = [
            'seconds' => $this->faker->numberBetween(1,120)
        ];

        $base_attributes = [
            'exercise_row_id' => ExerciseRow::factory(),
            'is_realisation' => $is_realisation,
            'completed' => false,
        ];
        return $base_attributes +
            ($is_realisation ? $is_realisation_attributes : []) +
            ($is_weight ? $is_weight_attributes : []) +
            ($is_reps ? $is_reps_attributes : []) +
            ($is_time ? $is_time_attributes : []);

    }
}
