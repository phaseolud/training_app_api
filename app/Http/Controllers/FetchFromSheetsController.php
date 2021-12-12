<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\ExerciseRow;
use App\Models\TrainingDay;
use App\Models\TrainingPeriod;
use App\Models\TrainingSet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Socialite\Facades\Socialite;
use Revolution\Google\Sheets\Facades\Sheets;

class FetchFromSheetsController extends Controller
{
    public function __invoke(Request $request)
    {
        $google_token = $request->user()->google_token;
        $google_user = Socialite::driver('google')->stateless()->userFromToken($google_token);

        $token = [
            'access_token' => $google_user->token,
            'refresh_token' => $google_user->refreshToken,
        ];
//        make the spreadsheet id dynamic by listing using google drive api
        $spreadsheet = Sheets::setAccessToken($token)->spreadsheet('10Y-FCl3ttvat2s2SdDBz_DT46Ncsdp3jDaGDh-MtI-M');
        $rows = $spreadsheet->sheet('programmering')->get();
        $header = $rows->pull(0);
        $header = array_pad($header, 12, "");

        // make the unkown columns equal to the index number
        array_walk($header, fn (&$item, $key) => $item = trim($item) ?: $key);

        $start_gsr = array_search('gewicht/sets/reps', $header);
        $end_gsr = array_search('RPE', $header) ?: 12;

        $data = Sheets::collection($header, $rows);

        $n_days = $data->pluck('dag')->except('e1rm')->map(fn($x) => intval($x))->max();
        $title = $spreadsheet->spreadSheetProperties()->title;
        $start_date = Str::of($title)->match("/\d+-\d+-\d+/");

        $training_period = TrainingPeriod::updateOrCreate(
            ['name' => $title],
            [
                'start_date' => $start_date,
                'user_id' => $request->user()->id,
                'n_days' => $n_days,
            ]
        );

        // create training days
        foreach ($data as $row) {
            // skip blank rows: are just visual separators
            if (! $row['oefening']) continue;
            // if we are at e1rm we don't have exercises anymore
            if ($row['dag'] == 'e1rm') break;

            // add day if it is in the first column
            if ($row['dag']) {
                $training_day = TrainingDay::firstOrCreate([
                    'index' => intval($row['dag']) - 1,
                    'name' => "Day " . $row['dag'],
                    'training_period_id' => $training_period->id
                ],['completed' => false,]);
            }

            // check if current exercise exists, and if not create it (with a review status)
            $exercise = Exercise::firstOrCreate(['name' => $row['oefening']],
                ['checked' => false]);


            // TODO: should check if there is a exercise row comment
            $exercise_row = ExerciseRow::firstOrCreate([
                'training_day_id' => $training_day->id,
                'exercise_id' => $exercise->id
            ]);

            // do some dirty processing for the input of the training set
            // each column can have a set (until RPE column), add a column can have multiple sets
            // starts at column with 'gewicht/sets/reps' ends at 'RPE'
            $set_index = 0;
            for($i=$start_gsr; $i < $end_gsr; $i++) {
                $cell = $row->slice($i, 1)->first();
                if (!$cell) break;

                // extract the cell info if it is not a comment
                if (!preg_match("/^\(.*\)/", $cell)) {
                    $set_info = extractSetInfo($cell);
                    for ($s = 0; $s < $set_info['sets']; $s++) {
                        $set_info_db = array_diff_key($set_info, array_flip(['sets']));
                        $training_set = TrainingSet::updateOrCreate([
                            'index' => $set_index,
                            'exercise_row_id' => $exercise_row->id,
                        ],['is_realisation' => false,
                            'completed' => false,
                            ...$set_info_db]);

                        $set_index++;
                    }
                }
            }
        }
        return response("Data loaded");
    }
}

function extractSetInfo(string $weight_set_rep) : array
{
    $weight_set_rep = Str::of($weight_set_rep);
    $set_info = [];

    // weight(,dec)xreps e.g. 85x12
    $matched = $weight_set_rep->match("/^\d+x\d+/");
    if ($matched->isNotEmpty()) {
        $matched_split  = $matched->split("/ |x/");
        $matched_split->transform(fn ($item, $key) => (float) $item);
        $set_info =  ["weight" => $matched_split[0], 'reps' => $matched_split[1]];
    }

    $matched = $weight_set_rep->match("/^\d+,\d+x\d+/");
    if ($matched->isNotEmpty()) {
        $matched_split = $matched->split("/ |,|x/");
        $matched_split->transform(fn ($item, $key) => (float) $item);
        $set_info =  ["weight" => $matched_split[0] + 0.1 * $matched_split[1], 'reps' => $matched_split[2]];
    }

//    weight(,dec) setxreps e.g. 85,5 2x10 85 2x10
    $matched = $weight_set_rep->match("/^\d+ \d+x\d+/");
    if ($matched->isNotEmpty()) {
        $matched_split = $matched->split("/ |x/");
        $matched_split->transform(fn ($item, $key) => (float) $item);
        $set_info =  ["weight" => $matched_split[0],'sets' => $matched_split[1], 'reps' => $matched_split[2]];
    }

    $matched = $weight_set_rep->match("/^\d+,\d+ \d+x\d+/");
    if ($matched->isNotEmpty()) {
        $matched_split = $matched->split("/ |,|x/");
        $matched_split->transform(fn ($item, $key) => (float) $item);
        $set_info =  ["weight" => $matched_split[0] + 0.1 * $matched_split[1],'sets' => $matched_split[2], 'reps' => $matched_split[3]];
    }

//    weight kg setsxreps e.g. 35 kg 5x10
    $matched = $weight_set_rep->match("/^\d+ kg \d+x\d+/");
    if ($matched->isNotEmpty()) {
        $matched_split = $matched->split("/kg |x/");
        $matched_split->transform(fn ($item, $key) => (float) $item);
        $set_info =  ["weight" => $matched_split[0] ,'sets' => $matched_split[1], 'reps' => $matched_split[2]];
    }
    $matched = $weight_set_rep->match("/^\d+,\d+ kg \d+x\d+/");
    if ($matched->isNotEmpty()) {
        $matched_split = $matched->split("/kg |,|x/");
        $matched_split->transform(fn ($item, $key) => (float) $item);
        $set_info =  ["weight" => $matched_split[0] + 0.1 * $matched_split[1],'sets' => $matched_split[2], 'reps' => $matched_split[3]];
    }

//    setsxtime e.g. 4x45 sec
    $matched = $weight_set_rep->match("/^\d+x\d+sec/");
    if ($matched->isNotEmpty()) {
        $matched_split = $matched->split("/x|sec/");
        $matched_split->transform(fn ($item, $key) => (float) $item);
        $set_info =  ['sets' => $matched_split[0], 'seconds' => $matched_split[1]];
    }

//    setxminreps-maxreps e.g. 5x10-15
    $matched = $weight_set_rep->match("/^\d+x\d+-\d+/");
    if ($matched->isNotEmpty()) {
        $matched_split = $matched->split("/x|-/");
        $matched_split->transform(fn ($item, $key) => (float) $item);
        $set_info =  ['sets' => $matched_split[0], 'reps_min' => $matched_split[1], 'reps_max' => $matched_split[2]];
    }

//    minweight-maxweightxreps e.g. 165-170x1
    $matched = $weight_set_rep->match("/^\d+-\d+x\d+/");
    if ($matched->isNotEmpty()) {
        $matched_split = $matched->split("/x|-/");
        $matched_split->transform(fn ($item, $key) => (float) $item);
        $set_info =  ['weight_min' => $matched_split[0], 'weight_max' => $matched_split[1], 'reps' => $matched_split[2]];
    }

    $matched = $weight_set_rep->match("/^\d+,\d+-\d+,\d+x\d+/");
    if ($matched->isNotEmpty()) {
        $matched_split = $matched->split("/x|,|-/");
        $matched_split->transform(fn ($item, $key) => (float) $item);
        $set_info =  ['weight_min' => $matched_split[0] + 0.1 * $matched_split[1], 'weight_max' => $matched_split[2] + 0.1* $matched_split[3],
            'reps' => $matched_split[4]];
    }

//    minweight-maxweight kg setsxreps e.g. 12-14 kg 3x10
    $matched = $weight_set_rep->match("/^\d+-\d+ kg \d+x\d+/");
    if ($matched->isNotEmpty()) {
        $matched_split = $matched->split("/x|-|kg /");
        $matched_split->transform(fn ($item, $key) => (float) $item);
        $set_info =  ['weight_min' => $matched_split[0], 'weight_max' => $matched_split[2], 'sets' => $matched_split[3],
            'reps' => $matched_split[4]];
    }

//    weight amrap e.g. 107,5 amrap
    $matched = $weight_set_rep->match("/^\d+ amrap/");
    if ($matched->isNotEmpty()) {
        $matched_split = $matched->split("/ amrap/");
        $matched_split->transform(fn ($item, $key) => (float) $item);
        $set_info =  ['weight' => $matched_split[0], 'amrap' => true];
    }

    $matched = $weight_set_rep->match("/^\d+,\d+ amrap/");
    if ($matched->isNotEmpty()) {
        $matched_split = $matched->split("/,| amrap/");
        $matched_split->transform(fn ($item, $key) => (float) $item);
        $set_info =  ['weight' => $matched_split[0] + 0.1 * $matched_split[1], 'amrap' => true];
    }

    if(!isset($set_info['sets'])) $set_info['sets'] = 1;
    return $set_info;

}
