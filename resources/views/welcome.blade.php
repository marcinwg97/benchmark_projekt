@extends('layouts.app')

@section('content')
<div class="container px-0" style="background-color: white">
        <div class="card border-0">
            <h4 class="card-header border-0 text-left px-3" style="background-color: #7952B3; color:white; border-radius: 0">
                Porównaj prędkość ładowania się strony z rankingiem
            </h4>
            <div class="card-body border-0 px-0 pt-0 pb-3">
                <form class="col-12 col-lg-12 px-0" enctype="multipart/form-data" action="{{ route('benchmark') }}"
                    method="post" accept-charset="utf-8">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="page" class="form-control border-top-0 rounded-top-0 px-3" placeholder="Wklej adres strony" aria-label="Adres strony">
                        <div class="input-group-append">
                          <button type="submit" class="btn btn-search" type="button">Sprawdź</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h1 class="lead text-center">TOP 5 najlepszych stron:</h1>
                <hr>
            </div>
        </div>
        <div class="row">
        <div style="width: 100%;margin: 0 auto;">
            {!! $chartTop->container() !!}
        </div>
        </div>
        {!! $chartTop->script() !!}
</div>
@endsection
