<?php
/**
 * Created by PhpStorm.
 * Project: pizza
 * User: Hasak
 * Date: 7. 9. 2020.
 * Time: 14:36
 */
?>
@extends('layout')
@section('title')Cart @endsection
@section('content')
    <div class="row">
        <div class="col c">
            <h1 class="display-4"><span class="fas fa-shopping-cart fa-fw"></span> Cart</h1>
            <p class="lead">Review and checkout</p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8" id="allpage">
            @if($items)
                <h3>Order no: {{$items[0]->orderID}}</h3>
                <small class="text-muted">You have {{Config::get('my_const.const.timeout_min')}} min to complete your order, otherwise Cart will be discarded.</small>
                <table class="table table-hover ntb mt-2">
                    <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th class="text-right">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $sum=0; @endphp
                    @foreach($items as $item)
                        @php $total=$item->itemid->price*$item->quantity; $sum+=$total; @endphp
                        <tr>
                            <td>{{$item->itemid->name}}</td>
                            <td>{{number_format($item->itemid->price,2,',','.')}} &euro;</td>
                            <td>{{$item->quantity}}</td>
                            <td class="font-weight-bold text-right">{{number_format($total,2,',','.')}} &euro;</td>
                        </tr>
                    @endforeach
                    <tr class='last-row'><td class='font-italic font-larger' colspan="3">SUM</td><td class='font-larger font-weight-bold text-right' id="sumprice" data-sum="{{$sum}}">{{number_format($sum,2,',','.')}} &euro;</td></tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <label for="addr">Please enter your shipping address:</label>
                    <table class="w-100">
                        <tr>
                            <td>
                                <input type="text" id="addr" class="form-control form-control-lg" name="address"
                                       placeholder="Shipping address" aria-describedby="desc" required>
                            </td>
                            <td class="text-right font-weight-bold">
                                <span class="fas fa-fw fa-plus"></span> <span id="shipprice" class="cprice">0,00</span> &euro;<br>
                                <small class="text-muted">Shipping cost</small>
                            </td>
                        </tr>
                    </table>
                    <small id="desc">Shipping is yet calculated by number of letters in the address. Each letter is 0,05 &euro;</small>
                </div>
                <input type="hidden" id="order_id" value="{{$items[0]->orderID}}" name="order_id">
                <span class="font-larger ml-2">TOTAL <span id="totalpricecalculated" class="ml-5 font-largerer font-weight-bold">{{number_format($sum,2,',','.')}}</span> &euro;</span>
                <button id="confirmer" class="btn btn-primary float-right"><span class="fas fa-fw fa-check"></span> Confirm</button>
            @else
                <h2><span class="fas fa-fw fa-times"></span> No items in Cart</h2>
                <p>You don't have anything in your cart yet. Add it <a href="{{asset('/order')}}">here</a>.</p>
            @endif
        </div>
        <div class="col-sm-2"></div>
    </div>
@endsection
