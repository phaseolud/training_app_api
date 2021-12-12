<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class TrainingPeriodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
//    #[ArrayShape(['start_date' => "string", 'n_days' => "int", 'user_id' => 'int'])]
    public function definition(): array
    {
        return [
            'name' => $this->faker->date('d-m-Y') . 'Period',
            'start_date' => $this->faker->date('d-m-Y'),
            'n_days' => $this->faker->randomNumber(),
            'user_id' => User::factory()
        ];
    }
}
