<?php

namespace App\Http\Controllers;

use App\Models\TrainingPeriod;
use Illuminate\Http\Request;

class TrainingPeriodController extends Controller
{
    public function index()
    {
        # return user->training_periods
        return auth()->user()->trainingPeriods;
    }

    public function show(TrainingPeriod $trainingPeriod)
    {
        return $trainingPeriod->load('trainingDays');
    }

    public function destroy(TrainingPeriod $trainingPeriod)
    {
        $trainingPeriod->delete();
        return response("Training period successfully deleted");
    }

}
