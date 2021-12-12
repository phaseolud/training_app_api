<?php

namespace App\Http\Controllers;

use App\Models\TrainingDay;
use Illuminate\Http\Request;

class TrainingDayController extends Controller
{
    public function show(TrainingDay $trainingDay)
    {
        return $trainingDay->load(['exerciseRows.exercise', 'exerciseRows.trainingSets']);
    }
}
