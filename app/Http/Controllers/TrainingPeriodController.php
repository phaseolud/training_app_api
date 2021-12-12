<?php

namespace App\Http\Controllers;

use App\Models\TrainingPeriod;
use Illuminate\Http\Request;

class TrainingPeriodController extends Controller
{
    public function index()
    {
        # return user->training_periods
        return TrainingPeriod::all();
    }

    public function show(TrainingPeriod $trainingPeriod)
    {
        return $trainingPeriod;
    }

    public function destroy(TrainingPeriod $trainingPeriod)
    {
        $trainingPeriod->delete();
        return response("Training period successfully deleted");
    }

}
