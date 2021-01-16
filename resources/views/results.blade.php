@extends('layouts.app')

@section('content')
<div class="container px-0" style="background-color: white">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row mx-0">
                <p class="col-12 text-left pt-3">Strona ładowała się <b>{!! isset($time) ? $time : "" !!} sekundy</b>, czas odpowiedzi wynosił <b>{!! isset($request) ? $request : "" !!} sekundy</b>,
                rozmiar strony to <b>{!! isset($size) ? $size : "" !!} bajtów</b>.<br>
                Strona załadowała się szybciej niż <b>{!! isset($percentage) ? round($percentage) : "" !!}%</b> stron w naszym rankingu.</p>
            </div>
        </div>
        <div class="px-3" style="width: 100%;margin: 0 auto;">
            {!! $chartAvg->container() !!}
        </div>
        {!! $chartAvg->script() !!}
        <div class="table-responsive ranking px-3">
            <table class="table table-striped table-hover table-sm">
                <thead>
                    <th>#</th>
                    <th class="text-left">Strona</th>
                    <th>Czas ładowania w ms</th>
                </thead>
                <tbody>
                    @foreach ($results_ranking as $page)
                        @if($benchmark->id == $page->id)
                        <tr style="background-color: #A353C9; color: white">
                        @else
                        <tr>
                        @endif
                            <th>{{$loop->iteration}}</th>
                            <td class="text-left">{{ str_replace('https://','',$page->page_name}})</td>
                            <td>{{ $page->load_time}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection