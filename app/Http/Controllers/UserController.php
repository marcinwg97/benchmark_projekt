<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\UserChart;
use App\Benchmark;
use Auth;
class UserController extends Controller
{
    
    public function index()
    {
        $benchmarks = Benchmark::where('user_id', Auth::user()->id)->get();
        return view('panel', compact('chart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date'
        ]);

        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $benchmarks = Benchmark::where('user_id', Auth::user()->id)->where('date', '<=', $request->date_to)->where('date', '>=', $request->date_from)->get();
        return view('panel')->with(['date_from' => $request->date_from, 'date_to' => $request->date_to]);
    }
   
}
