<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StatsController extends Controller
{

    public function get($browserId)
    {
        $today = date('Y-m-d');

        $allAttemptsToday = Attempt::whereDate('created_at', $today)->get();

        $correctPercentageToday = $allAttemptsToday->count() !== 0
            ? round($allAttemptsToday->where('is_correct', true)->count() / $allAttemptsToday->count() * 100, 0)
            : 0;

        $averageAttempts = round(DB::table('attempts')
            ->whereDate('created_at', $today)
            ->where('is_correct', true)
            ->avg('attempts'), 1);


        $distribution = [];
        for ($i = 1; $i <= 6; $i++) {
            $count = DB::table('attempts')
                ->whereDate('created_at', $today)
                ->where('attempts', $i)
                ->count();
            $distribution['r' . $i] = $count;
        }

        $currentPersonCorrectAttempts = Attempt::where('browser_id', $browserId)
            ->where('is_correct', true)
            ->count();

        $totalUsers = Attempt::select('browser_id')->groupBy('browser_id')->get()->count();

        $usersWithFewerCorrectAttempts = Attempt::select('browser_id')
            ->selectRaw('SUM(is_correct) as correct_attempts')
            ->groupBy('browser_id')
            ->having('correct_attempts', '<', $currentPersonCorrectAttempts)
            ->count();

        $percentileRank = round((($usersWithFewerCorrectAttempts + 1) / $totalUsers) * 100, 0);


        return response()->json([
            'correctPercentage' => $correctPercentageToday,
            'averageAttempts' => $averageAttempts,
            'distribution' => $distribution,
            'percentileRank' => $percentileRank
        ]);
    }
}
