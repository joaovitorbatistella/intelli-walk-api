<?php

namespace App\Http\Controllers;

use App\Occurrences;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OccurenceController extends Controller
{
    public function getAverage() {
        $occurences = Occurrences::select(DB::raw('DATE(created_at) AS date, AVG(pressure) AS avg'))
                                 ->where('gear_id', 2)
                                 ->whereRaw('created_at > DATE_SUB(NOW(), INTERVAL 7 DAY)')
                                 ->groupBy('date')
                                 ->get();

        return response()->json([
            "success" => true,
            "data"    => $occurences
        ]);
    }
}
