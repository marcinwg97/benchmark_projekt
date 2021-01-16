@extends('layouts.app')

@section('content')

<div class="container">
<div class="row mx-0 mb-0 mt-3">
        <div class="col-12">
            <h4 class="mb-0 text-center">Panel</h4>
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
                    <button type="submit" class="btn btn-success">Filtruj</button>
                </div>
            </div>
        </form>
    </div>
    <div class="row justify-content-center">
<div style="width: 80%;margin: 0 auto;">
            {!! $chart->container() !!}
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
        {!! $chart->script() !!}
</div>
</div>
@endsection
