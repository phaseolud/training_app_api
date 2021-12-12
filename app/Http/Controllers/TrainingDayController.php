<?php

namespace App\Http\Controllers;

use App\Models\TrainingDay;
use Illuminate\Http\Request;

class TrainingDayController extends Controller
{
    public function index()
    {
        return TrainingDay::all();
    }

    public function show(TrainingDay $trainingDay)
    {
        return $trainingDay;
    }
}
