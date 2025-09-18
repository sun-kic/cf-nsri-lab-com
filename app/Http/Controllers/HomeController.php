<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Today;
use App\Models\Carbonsum;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $carbon = Carbonsum::where('user_id', auth()->id())->latest()->first();
        $sevendays = Carbon::today()->subDay(7);
        $carbon_oneweek = Today::where('user_id', auth()->id())->whereDate('activity_date', '>', $sevendays)->get();
        $carbon_today = Today::where('user_id', auth()->id())->whereDate('activity_date', Carbon::today())->first();
        $user = User::where('id', auth()->id())->first();
        $days_count = Today::where('user_id', auth()->id())->count();
        $works = [];
        $move = [];
        $life = [];
        $foods = [];
        $days = [];

        // Convert collection to array and sort
        $carbon_oneweek_array = $carbon_oneweek->toArray();
        usort($carbon_oneweek_array, [$this, 'compareActivityDate']);

        foreach ($carbon_oneweek_array as $row) {
            array_push($works, $row['works_carbon']);
            array_push($foods, $row['foods_carbon']);
            array_push($move, $row['move_carbon']);
            array_push($life, $row['life_carbon']);
            array_push($days, Carbon::parse($row['activity_date'])->format('m/d'));
        }

        return view('homes.index', [
            'carbon' => $carbon,
            'days_count' => $days_count,
            'carbon_today' => $carbon_today,
            'days' => $days,
            'works' => $works,
            'move' => $move,
            'life' => $life,
            'foods' => $foods,
            'user' => $user
        ]);
    }

    private function compareActivityDate($a, $b)
    {
        return strtotime($a['activity_date']) - strtotime($b['activity_date']);
    }
}