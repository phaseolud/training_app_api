<?php

namespace Database\Factories;

use App\Models\TrainingPeriod;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class TrainingDayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape(['index' => "int", 'name' => "string", 'date' => "string", 'completed' => "false", 'training_period_id' => "int"])]
    public function definition(): array
    {
        return [
            'index' => $this->faker->randomNumber(),
            'name' => $this->faker->word(),
            'date' => $this->faker->date(),
            'completed' => false,
            'training_period_id' => TrainingPeriod::factory(),
        ];
    }
}
