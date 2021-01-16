<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use App\Benchmark;
use App\BenchmarkNumber;
use Auth;
use App\Charts\UserChart;

class BenchmarkController extends Controller
{
   
	function getLoadPage($interval=NULL, $page) {
		#time between updates in hours
		if(!$interval) {
			$interval=1;
		}
		#check if an update is due
		$now = time();
		$arrContextOptions=array(
			"ssl"=>array(
				"verify_peer"=>false,
				"verify_peer_name"=>false,
			),
		);  
			#check loadtime
			$total = 0;
			$start = microtime(true);
			$page = file_get_contents($page, false, stream_context_create($arrContextOptions));
			$total += microtime(true)-$start;
				   preg_match_all('/src=(["\']?)([^\1]+?)\1/m', $page, $result, PREG_PATTERN_ORDER);
				$result = $result[2];
				   foreach($result as $src) {
					   $start = microtime(true);
					   @file_get_contents($src);
					   $total += microtime(true)-$start;
				   }
				   
				$out = substr($total, 0, 6);
		
		return $out;
	}


	function getSizeOfPage($page) {
		$url = $page; 
		$curl = curl_init($url); 
		curl_setopt($curl, CURLOPT_VERBOSE, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$subject = curl_exec($curl); 
		//get the download size of page 
		return curl_getinfo($curl, CURLINFO_SIZE_DOWNLOAD);
	//	print("Download size: " . curl_getinfo($curl, CURLINFO_SIZE_DOWNLOAD) .'<br>');

/* preg_match_all('/(?:src=)"([^"]*)"/m', $subject, $matchessrc);

preg_match_all('/link.*\s*(?:href=)"([^"]*)"/m', $subject, $matcheslink);

$matches = array_merge($matchessrc[1], $matcheslink[1]);

$domain = parse_url($url, PHP_URL_SCHEME). '://'.parse_url($url, PHP_URL_HOST);
$path = parse_url($url, PHP_URL_PATH);

$checked = array();
foreach($matches as $m)
{
    if($m[0] == '/')
        $m = $domain.$m;
    elseif(substr($m, 0, 5) != 'http:' and substr($m, 0, 6) != 'https:')
        $m = $domain.'/'.$path.'/'.$m;

    if(in_array($m, $checked))
        continue;

    $checked[] = $m;

    $curl = curl_init($m);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $subject = curl_exec($curl);
    //get the download size of element
    print("Download size: " . curl_getinfo($curl, CURLINFO_SIZE_DOWNLOAD) .'<br>');
} */
	}

	function getTimeOfRequest($page) {
		$url = $page;
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_VERBOSE, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	
		$subject = curl_exec($curl); 
		//get the download size of page 
		return curl_getinfo($curl, CURLINFO_TOTAL_TIME);

	}

   	public function benchmark(Request $request) {
    
	$page = $request->page;
	//Usuwanie http, https i www
	$source = ['https://www.','https://','http://www.','http://'];
	$replace = ['','','',''];
	$page_trunc = str_replace($source,$replace,$page);
	//
	$time = $this->getLoadPage(NULL, $page);
	$request = $this->getTimeOfRequest($page);
	$size = $this->getSizeOfPage($page);
	$benchmark = new Benchmark;
	$benchmark->date = date('Y-m-d');
	$benchmark->load_time = $time;
	$benchmark->page_name = $page_trunc;
	$benchmark->request_time = $request;
	$benchmark->size_page = $size; 
	if(Auth::user()) {
		$benchmark->user_id = Auth::user()->id;
	}
	$benchmark->save();

	$benchmark_avg = Benchmark::where('id', '!=', $benchmark->id)->avg('load_time');
		
	$chartAvg = new UserChart;
	$chartAvg->labels(['Średnia', $page]);
	$chartAvg->dataset('Czas ładowania w ms', 'bar', [$benchmark_avg, $time])
            ->color("black")
            ->backgroundcolor("#DAC2FF")
            ->fill(false)
			->linetension(0.5);
	
	$cnt = 0;
	$benchmark_count = Benchmark::orderBy('load_time', 'asc')->get(); 
	foreach($benchmark_count as $key => $bc) {
		if($bc->id == $benchmark->id) {
			$cnt = $key + 1;
		}
	}
	$percentage = ($cnt / $benchmark_count->count()) * 100;
	$percentage = 100 - $percentage;

	$results_ranking = Benchmark::orderBy('load_time','asc')->take(10)->get();

    return view('results')->with(['time' => $time, 'size' => $size, 'request' => $request, 'chartAvg' => $chartAvg, 'percentage' => $percentage, 'results_ranking' => $results_ranking, 'benchmark' => $benchmark]);
   }

   
}
