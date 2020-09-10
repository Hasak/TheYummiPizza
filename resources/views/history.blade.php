<?php
/**
 * Created by PhpStorm.
 * Project: pizza
 * User: Hasak
 * Date: 7. 9. 2020.
 * Time: 14:35
 */
?>
@extends('layout')
@section('title')History @endsection
@section('content')
    <div class="row">
        <div class="col c">
            <h1 class="display-4"><span class="fas fa-history fa-fw"></span> History</h1>
            <p class="lead">Here you can find your previous orders</p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8" id="allpage">
            @if(sizeof($orders))
                <table class="table table-hover ntb mt-2">
                    <thead>
                    <tr>
                        <th>Order no.</th>
                        <th>Items</th>
                        <th>Address</th>
                        <th>Order Time</th>
                        <th class="text-right">Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        @php $sum=0; @endphp
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>@foreach($items as $item)
                                    @if($item->orderID==$order->id)
                                         · {{$item->itemid->name}} &times; {{$item->quantity}}<br>
                                        @php $sum+=$item->itemid->price*$item->quantity; @endphp
                                    @endif
                                @endforeach</td>
                            <td>{{$order->address}}</td>
                            <td>{{date("Y-m-d @ H:i",$order->confirmed_time)}}</td>
                            <td class="font-weight-bold text-right">{{number_format($sum,2,',','.')}} &euro;</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <h2><span class="fas fa-fw fa-times"></span> No items in History</h2>
                <p>You don't have anything in your history yet. Add it <a href="{{asset('/order')}}">here</a>.</p>
            @endif
        </div>
        <div class="col-sm-2"></div>
    </div>
@endsection
