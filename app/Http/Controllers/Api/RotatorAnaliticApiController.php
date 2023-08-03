<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Click;
use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RotatorAnaliticApiController extends Controller
{
    function getLineClickID($url)
    {
        $year = request()->year;
        $month = request()->month;
        $filter = $year . '-' . $month;

        $parse = Carbon::parse($filter);
        $array_date = range($parse->startOfMonth()->format('d'), $parse->endOfMonth()->format('d'));
        $click = Click::where('url_name', $url)
            ->where('click_time', 'LIKE', '%' . $filter . '%')
            ->select(
                DB::raw('COUNT(click_time) as count'),
                DB::raw('click_time as date')
            )
            ->groupBy('click_time')
            ->get();
        $data = [];
        foreach ($array_date as $row) {
            $f_date = strlen($row) == 1 ? 0 . $row : $row;
            $date = $filter . '-' . $f_date;
            $total = $click->firstWhere('date', $date);
            $data[] = [
                'date' => $date,
                'total' => $total ? $total->count : 0,
            ];
        }
        return response()->json(['status' => true, 'data' => $data], 200);
    }

    function getLineClick()
    {
        $year = request()->year;
        $month = request()->month;
        $filter = $year . '-' . $month;

        $parse = Carbon::parse($filter);
        $array_date = range($parse->startOfMonth()->format('d'), $parse->endOfMonth()->format('d'));
        $click = Click::where('click_time', 'LIKE', '%' . $filter . '%')
            ->select(
                DB::raw('COUNT(click_time) as count'),
                DB::raw('click_time as date')
            )
            ->groupBy('click_time')
            ->get();
        $data = [];
        foreach ($array_date as $row) {
            $f_date = strlen($row) == 1 ? 0 . $row : $row;
            $date = $filter . '-' . $f_date;
            $total = $click->firstWhere('date', $date);
            $data[] = [
                'date' => $date,
                'total' => $total ? $total->count : 0,
            ];
        }
        return response()->json(['status' => true, 'data' => $data], 200);
    }
}
