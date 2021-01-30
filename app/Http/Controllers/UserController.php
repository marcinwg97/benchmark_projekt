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
        $benchmarks2 = Benchmark::where('user_id', Auth::user()->id)->orderBy('load_time', 'asc')->get();

        $labels = array();
        $data = array();

        foreach($benchmarks2 as $benchmark) {
            $labels[] = $benchmark->page_name;
            $data[] = $benchmark->load_time;
        }
        $chartUser = new UserChart;
      
        $chartUser->labels($labels);
        $chartUser->dataset('Czas ładowania (s)', 'bar', $data)
            ->color("black")
            ->backgroundcolor("#DAC2FF")
            ->fill(false)
            ->linetension(0.5);

        return view('panel')->with(['benchmarks' => $benchmarks, 'chartUser' => $chartUser]);
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
        $benchmarks2 = Benchmark::where('user_id', Auth::user()->id)->where('date', '<=', $request->date_to)->where('date', '>=', $request->date_from)->orderBy('load_time', 'asc')->get();
        $labels = array();
        $data = array();

        foreach($benchmarks2 as $benchmark) {
            $labels[] = $benchmark->page_name;
            $data[] = $benchmark->load_time;
        }
        $chartUser = new UserChart;
      
        $chartUser->labels($labels);
        $chartUser->dataset('Czas ładowania (s)', 'bar', $data)
            ->color("black")
            ->backgroundcolor("#DAC2FF")
            ->fill(false)
            ->linetension(0.5);

        return view('panel')->with(['date_from' => $request->date_from, 'date_to' => $request->date_to, 'benchmarks' => $benchmarks, 'chartUser' => $chartUser]);
    }
   
}
