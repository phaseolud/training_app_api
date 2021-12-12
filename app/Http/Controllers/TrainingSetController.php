<?php

namespace App\Http\Controllers;

use App\Models\TrainingSet;
use Illuminate\Http\Request;

class TrainingSetController extends Controller
{
    public function index()
    {
        return TrainingSet::all();
    }

    public function show(TrainingSet $trainingSet)
    {
        return $trainingSet;
    }
}
