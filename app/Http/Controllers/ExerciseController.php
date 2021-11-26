<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

#TODO: Implement the other ExerciseController methods

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Exercise[]|Collection
     */
    public function index(): Collection|array
    {
        return Exercise::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Exercise $exercise
     * @return Response
     */
    public function show(Exercise $exercise)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Exercise $exercise
     * @return Response
     */
    public function update(Request $request, Exercise $exercise)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Exercise $exercise
     * @return Response
     */
    public function destroy(Exercise $exercise): Response
    {
        $exercise->delete();
        return response("Deleted successfully");
    }
}
