<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\TrainingDay;
use App\Models\TrainingPeriod;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $training_periods = TrainingPeriod::factory()->count(2)->create(['user_id' => 1]);
        $exercises = Exercise::factory()->count(10)->create();
        foreach ($training_periods as $training_period)
            $training_days = TrainingDay::factory()->count(4)->create(['training_period_id' => $training_period->id]);
    }
}
