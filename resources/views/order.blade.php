<?php
/**
 * Created by PhpStorm.
 * Project: pizza
 * User: Hasak
 * Date: 6. 9. 2020.
 * Time: 17:08
 */
?>
@extends('layout')
@section('title')Order @endsection
@section('content')
    <div class="row">
        <div class="col c">
            <h1 class="display-4"><span class="fas fa-pizza-slice fa-fw"></span> Order</h1>
            <p class="lead">Order your delicious menu</p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                @foreach($cats as $item)
                    <li class="nav-item">
                        <a class="nav-link" id="cattab{{$item->id}}-tab" data-toggle="tab" href="#catpane{{$item->id}}"
                           role="tab"
                           aria-controls="catpane{{$item->id}}" aria-selected="true">
                            <span class="fas fa-fw {{$item->icon}}"></span> {{$item->name}}
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content" id="myTabContent">
                @foreach($fortabs as $cat)
                    <div class="tab-pane fade" id="catpane{{$cat[0]->category}}" role="tabpanel" aria-labelledby="cattab{{$cat[0]->category}}-tab">
                        <table class="table table-sm ntb mt-3">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th class="text-right">Total</th>
                                <th class="text-right">Add to Cart</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cat as $item)
                                <tr data-id="{{$item->id}}" class="item-row">
                                    <td>{{$item->name}}</td>
                                    <td class="price" data-price="{{$item->price}}">{{number_format($item->price,2,',','.')}} &euro;</td>
                                    <td>
                                        <select class="form-control-sm quantity" data-id="{{$item->id}}" name="quantity{{$item->id}}" id="quantity{{$item->id}}">
                                            @for($i=0;$i<11;$i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                    </td>
                                    <td class="text-right font-weight-bold total"></td>
                                    <td class="text-right">
                                        <button class="btn btn-sm btn-primary to-cart" data-id="{{$item->id}}" disabled><span class="fas fa-fw fa-check"></span> To Cart</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>

        </div>
        <div class="col-sm-3">
            <div class="card border-primary">
                <div class="card-header">
                    <span class="fas fa-fw fa-shopping-cart"></span> Your Cart
                </div>
                <div id="cartcard" class="card-body">
                    <h5 class="card-title c"><span class="fas fa-fw fa-spin fa-sync-alt"></span> Your Cart is loading...</h5>
                </div>
            </div>
            <div id="erroralert" class="alert alert-danger dn alert-dismissible fade show mt-2" role="alert">
                Error occured
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>

@endsection
