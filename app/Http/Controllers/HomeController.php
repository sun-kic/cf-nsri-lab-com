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
        $userId = auth()->id();
        $carbon = Carbonsum::where('user_id', $userId)->latest()->first();
        $sevenDaysAgo = Carbon::today()->subDays(7);

        $weeklyEntries = Today::query()
            ->where('user_id', $userId)
            ->whereDate('activity_date', '>', $sevenDaysAgo)
            ->orderBy('activity_date')
            ->get(['activity_date', 'works_carbon', 'foods_carbon', 'move_carbon', 'life_carbon']);

        $carbonToday = Today::where('user_id', $userId)
            ->whereDate('activity_date', Carbon::today())
            ->first();

        $user = User::find($userId);
        $daysCount = Today::where('user_id', $userId)->count();

        $days = $weeklyEntries
            ->map(fn ($entry) => Carbon::parse($entry->activity_date)->format('m/d'))
            ->all();

        $works = $weeklyEntries->pluck('works_carbon')->all();
        $foods = $weeklyEntries->pluck('foods_carbon')->all();
        $move = $weeklyEntries->pluck('move_carbon')->all();
        $life = $weeklyEntries->pluck('life_carbon')->all();

        return view('homes.index', [
            'carbon' => $carbon,
            'days_count' => $daysCount,
            'carbon_today' => $carbonToday,
            'days' => $days,
            'works' => $works,
            'move' => $move,
            'life' => $life,
            'foods' => $foods,
            'user' => $user
        ]);
    }
}
