<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Occurrences;
use Illuminate\Http\Request;
use App\Jobs\SendMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function handleEvent(Request $request) {
        $sentAlert = false;
        $data = (object) $request->all();

        $data_sheet = $data->data;
        $gear_id = $data->gear_id;

        $avg = DB::select("SELECT dailyDistanceAverage($gear_id) AS avg")[0]->avg;
        $avgPressure = DB::select("SELECT dailyPressureAverage($gear_id) AS avg")[0]->avg;

        $i = 0;
        foreach ($data_sheet as $key => $value) {
            $dAb = sqrt(pow($value['position_right_x'] - $value['position_left_x'], 2) + pow($value['position_right_y'] - $value['position_left_y'], 2)  );

            if($dAb > $avg || $value['pressure'] > $avgPressure) {
                $i++;
            } else {
                $i = 0;
            }

            if($i >= 10 && !$sentAlert) {
                Log::info("variacao");
                SendMessage::dispatch($dAb, $avg);
                $sentAlert = true;
            }

            Occurrences::create([
                "distance"          => $dAb,
                "position_left_x"   => $value['position_left_x'],
                "position_left_y"   => $value['position_left_y'],
                "position_right_x"  => $value['position_right_x'],
                "position_right_y"  => $value['position_right_y'],
                "pressure"          => $value['pressure'],
                "gear_id"           => $gear_id
            ]);
        }

        return response()->json([
            "success" => true
        ]);

    }
}
