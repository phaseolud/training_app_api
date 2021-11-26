<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class TrainingPeriodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape(['start_date' => "string", 'n_days' => "int"])]
    public function definition(): array
    {
        return [
            'start_date' => $this->faker->date(),
            'n_days' => $this->faker->randomNumber()
        ];
    }
}
