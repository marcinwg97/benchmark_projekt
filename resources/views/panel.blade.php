@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row mx-0 mb-0 mt-3">
        <div class="col-12">
            <h1 class="mb-0 text-center lead">Panel</h1>
            <hr>
        </div>
        <form class="col-12 px-0" method="post" action="{{ route('panel.store') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6 col-12 px-0 px-lg-3">
                    <label for="date_from" style="display:inline-block; font-weight: bold">Data od:</label>
                    <div style="position: relative;">
                        <input id="date_from" type="date" class="form-control" aria-label="" name="date_from" value={!!
                            isset($date_from) ? $date_from : "" !!}>
                        <i id="close-button-from" class="close-button fas fa-times"></i>
                    </div>
                </div>
                <div class="col-md-6 col-12 px-0 px-lg-3">
                    <label for="date_to" style="display:inline-block; font-weight: bold">Data do:</label>
                    <div style="position: relative;">
                        <input id="date_to" type="date" class="form-control" aria-label="" name="date_to" value={!!
                            isset($date_to) ? $date_to : "" !!}>
                        <i id="close-button-to" class="close-button fas fa-times"></i>
                        @if ($errors->has('date_to'))
                        <span class="help-block" style="font-size: 13px">
                            <strong class="pl-2 pl-lg-3">{{ $errors->first('date_to') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-12 my-2 px-0 px-lg-3 text-right">
                    <button type="submit" class="btn btn-success" style="background-color: rgb(121, 82, 179); !important; border-color: rgb(121, 82, 179);">Filtruj</button>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div style="width: 100%;margin: 0 auto;">
            {!! $chartUser->container() !!}
        </div>
    </div>
    <div class="row mt-3">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nazwa strony</th>
                        <th>Czas ładowania</th>
                        <th>Czas odpowiedzi</th>
                        <th>Rozmiar strony</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($benchmarks as $benchmark)
                    <tr>
                    <td>{{$benchmark->page_name}}</td>
                    <td>{{$benchmark->load_time}} s</td>
                    <td>{{$benchmark->request_time}} s</td>
                    <td>{{$benchmark->size_page}} kB</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>    
@endsection
