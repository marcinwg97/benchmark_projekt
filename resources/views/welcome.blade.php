@extends('layouts.app')

@section('content')
<div class="container">
        <form class="col-12 col-lg-12" enctype="multipart/form-data" action="{{ route('benchmark') }}"
            method="post" accept-charset="utf-8">
            @csrf
            <div class="form-group row">
                <input type="text" name="page" class="form-control" required autofocus>
            </div>
            <div class="form-group col-12">
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Dodaj</button>
                </div>
            </div>
        </form>
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
