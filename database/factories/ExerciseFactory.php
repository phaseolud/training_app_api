<?php

namespace Database\Factories;

use App\Enums\MuscleGroup;
use App\Models\Exercise;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class ExerciseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape(['name' => "string", 'muscle_groups' => "array", 'parent_id' => "int"])]
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'muscle_groups' => $this->faker->randomElements(MuscleGroup::cases(),2),
            'parent_id' => $this->faker->boolean() ? Exercise::factory() : null,
        ];
    }
}
