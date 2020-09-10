@extends('layout')
@section('title')TYP @endsection
@section('content')
    <div class="row">
        <div class="col c">
            <h1 class="display-4"><span class="fas fa-pizza-slice fa-fw"></span> TYP</h1>
            <p class="lead">Welcome @if(Auth::id()) <span class="font-weight-bold">{{$u->name}}</span> @endif to The Yummi Pizza</p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <br>
            <p>Now orders become easier!</p>
            <p>Simply klick <a href="{{asset("/order")}}">here</a> and start ordering</p>
        </div>
        <div class="col-sm-2"></div>
    </div>
@endsection
