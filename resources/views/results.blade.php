@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
<p>Czas ładowania: {!! isset($time) ? $time : "" !!}</p>
<p>Czas odpowiedzi: {!! isset($request) ? $request : "" !!}</p>
<p>Rozmiar strony: {!! isset($size) ? $size : "" !!}</p>

<p>Procent: {!! isset($percentage) ? round($percentage) : "" !!}</p>

        <div style="width: 100%;margin: 0 auto;">
            {!! $chartAvg->container() !!}
        </div>
        {!! $chartAvg->script() !!}
</div>
</div>
@endsection