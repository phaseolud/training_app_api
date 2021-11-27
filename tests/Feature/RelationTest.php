<?php

use App\Models\Exercise;
use App\Models\ExerciseRow;
use App\Models\TrainingDay;
use App\Models\TrainingPeriod;
use App\Models\TrainingSet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function PHPUnit\Framework\assertInstanceOf;

uses(RefreshDatabase::class);

test('user has a training period', function() {
   $user = User::factory()->has(TrainingPeriod::factory()->count(2))->create();
   assertInstanceOf(TrainingPeriod::class, $user->trainingPeriods[0]);
});

test('training period has training days and belongs to user', function() {
    $training_period = TrainingPeriod::factory()->has(TrainingDay::factory()->count(2))->create();
    assertInstanceOf(TrainingDay::class, $training_period->trainingDays[0]);
    assertInstanceOf(User::class, $training_period->user);
});

test('training day exercise rows and belongs to trainingperiod', function() {
    $training_day = TrainingDay::factory()->has(ExerciseRow::factory()->count(2))->create();
    assertInstanceOf(ExerciseRow::class, $training_day->exerciseRows[0]);
    assertInstanceOf(TrainingPeriod::class, $training_day->trainingPeriod);
});

test('exercise row has sets and belongs to training day and exercise', function() {
    $exercise_row = ExerciseRow::factory()->has(TrainingSet::factory()->count(2))->create();
    assertInstanceOf(TrainingSet::class, $exercise_row->trainingSets[0]);
    assertInstanceOf(TrainingDay::class, $exercise_row->trainingDay);
    assertInstanceOf(Exercise::class, $exercise_row->exercise);
});

test('set belongs to an exercise row', function() {
$training_set = TrainingSet::factory()->create();
    assertInstanceOf(ExerciseRow::class, $training_set->exerciseRow);
});
