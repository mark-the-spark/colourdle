<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AttemptsController extends Controller
{
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
}
