@extends('layouts.app')

@section('content')
<div class="container px-0" style="background-color: white">
    <div class="row justify-content-center">
        <div class="col-12">
        <h1 class="lead m-4">Wyniki dla strony {!! isset($page) ? $page : "" !!}</h1>
            <div class="row mx-0 mt-4">
                <div class="col-lg-3 col-12">
                    <div class="status-block">
                        <div class="status-block-box">
                            <div class="block-label">Czas ładowania</div>
                            <div class="block-field"><span class="big">{!! isset($time) ? $time : "" !!}</span><span> s</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <div class="status-block">
                        <div class="status-block-box">
                            <div class="block-label">Rozmiar strony</div>
                            <div class="block-field"><span class="big">{!! isset($size) ? $size : "" !!}</span><span> B</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <div class="status-block">
                        <div class="status-block-box">
                            <div class="block-label">czas odpowiedzi</div>
                            <div class="block-field"><span class="big">{!! isset($request) ? $request : "" !!}</span><span> s</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <div class="status-block">
                        <div class="status-block-box">
                            <div class="block-label">Ładuje się szybciej niż</div>
                            <div class="block-field"><span class="big">{!! isset($percentage) ? round($percentage) : "" !!}</span><span> %</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-3" style="width: 50%;margin: 0 auto;">
            {!! $chartAvg->container() !!}
        </div>
        {!! $chartAvg->script() !!}
        <div class="table-responsive ranking px-3">
            <table class="table table-striped table-hover table-sm">
                <thead>
                    <th>#</th>
                    <th class="text-left">Strona</th>
                    <th>Czas ładowania (s)</th>
                </thead>
                <tbody>
                    @foreach ($results_ranking as $page)
                        @if($benchmark->id == $page->id)
                        <tr style="background-color: #A353C9; color: white">
                        @else
                        <tr>
                        @endif
                            <th>{{$loop->iteration}}</th>
                            <td class="text-left">{{$page->page_name}}</td>
                            <td>{{ $page->load_time}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection