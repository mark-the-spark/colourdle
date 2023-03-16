<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttemptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info($request);

        $validatedData = $request->validate([
            'browser_id' => 'required',
            'guess' => 'required',
            'is_correct' => 'required',
            'attempts' => 'required',
        ]);

        $attempt = Attempt::create($validatedData);

        return response()->json(['attempt' => $attempt, 'message' => 'Game result stored successfully!']);
    }


    public function getAverageAttemptsToday()
    {
        $today = date('Y-m-d');

        $allAttempts = Attempt::whereDate('created_at', $today)->get();

        $correctPercentage =  round($allAttempts->where('is_correct', true)->count() / $allAttempts->count() * 100, 0);

        

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


        return response()->json([
            'correctPercentage' => $correctPercentage,
            'averageAttempts' => $averageAttempts,
            'distribution' => $distribution
        ]);
    }
}
