<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\UserChart;
use App\Benchmark;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $benchmarks = Benchmark::orderBy('load_time', 'asc')->get()->take(5);
        $labels = array();
        $data = array();

        foreach($benchmarks as $benchmark) {
            $labels[] = $benchmark->page_name;
            $data[] = $benchmark->load_time;
        }
        $chartTop = new UserChart;
      
        $chartTop->labels($labels);
        $chartTop->dataset('Czas ładowania (s)', 'bar', $data)
            ->color("black")
            ->backgroundcolor("#DAC2FF")
            ->fill(false)
            ->linetension(0.5);

        return view('welcome', compact('chartTop'));
    }
}
