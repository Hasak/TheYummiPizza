<?php

use App\Item;
use App\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    if(Auth::id())
        $u=DB::table('users')->find(Auth::id());
    else $u=null;
    return view('index',compact('u'));
});

Auth::routes();

Route::get('/home',function(){
    return redirect('/');
});

Route::group(['middleware'=>'auth'],function(){
    Route::get('/order',function(){
        //$menu=DB::table('menu')->get();
        $cats=DB::table('categories')->get();
        $fortabs=null;
        foreach($cats as $cat){
            $fortabs[$cat->id]=DB::table('menu')->where('category',$cat->id)->get();
        }
        //dd($fortabs);
        return view('order',compact('cats','fortabs'));
    });

    Route::get('/history',function(){
        $allorders=Order::where('uid',Auth::id())->pluck('id');
        $items=Item::whereIn('orderID',$allorders)->get();
        $orders=Order::where('uid',Auth::id())->where('ordered',1)->orderBy('id','desc')->get();
        //dd(sizeof($orders));
        //dd($items);
        return view('history',compact('orders','items'));
    });

    Route::get('/account',function(){
        return view('account');
    });

    Route::get('/cart',function(){
        $TIMEOUT_MIN=Config::get('my_const.const.timeout_min');
        $timeout=60*$TIMEOUT_MIN; // 30 min
        $mintime=time()-$timeout;
        $order=Order::where('uid',Auth::id())->where('ordered_time','>',$mintime)->where('ordered',0)->orderBy('id','desc')->first();
        if($order){
            $time_refresh=Order::find($order->id);
            $time_refresh->save();
            $items=Item::where('orderID',$order->id)->get();
        }
        else $items=null;
        return view('cart',compact('items'));
    });

    Route::post('/cartcard',function(){
        $TIMEOUT_MIN=Config::get('my_const.const.timeout_min');
        $timeout=60*$TIMEOUT_MIN; // 30 min
        $mintime=time()-$timeout;
        $forreturn="";
        $order=Order::where('uid',Auth::id())->where('ordered_time','>',$mintime)->where('ordered',0)->orderBy('id','desc')->first();
        if($order){
            $time_refresh=Order::find($order->id);
            $time_refresh->save();
            $total_price=0;
            $items=Item::where('orderid',$order->id)->get();
            $forreturn.="<p class='text-muted'>You have ".$TIMEOUT_MIN." min to complete your order, otherwise Cart will be discarded.</p>";
            $forreturn.="<table class='table table-sm table-hover'>";
            foreach($items as $item){
                $calculated_price=$item->itemid->price*$item->quantity;
                $forreturn.="<tr><td>".$item->itemid->name." &times; ".$item->quantity."</td>";
                $forreturn.="<td class='font-weight-bold text-right'>".number_format($calculated_price,2,',','.')." &euro;</td>";
                $forreturn.="<td class='text-danger ptr for-delete' data-id='".$item->id."' onclick='deleteitem($(this),".$item->id.")'><span class='fas fa-fw fa-times'></span></td></tr>";
                $total_price+=$calculated_price;
            }
            $forreturn.="<tr class='last-row'><td class='font-italic font-larger'>SUM</td><td class='font-larger font-weight-bold text-right'>".number_format($total_price,2,',','.')." &euro;</td><td></td></tr>";
            $forreturn.="</table>";
            $forreturn.="<a id='tocheckbtn' href=".asset('/cart')." class='btn btn-primary float-right'><span class='fas fa-fw fa-check'></span> To Checkout</a>";
            $forreturn.="<button id='toemptycart' class='btn btn-outline-danger float-right mr-2' onclick='deleteorder(".$order->id.")'><span class='fas fa-fw fa-times'></span> Empty Cart</button>";
        }
        else $forreturn.="<p class='card-text text-muted c'>Your Cart is empty</p>";
        return $forreturn;
    });

    Route::post('/addtocart',function(){
        $TIMEOUT_MIN=Config::get('my_const.const.timeout_min');
        $timeout=60*$TIMEOUT_MIN; // 30 min
        $mintime=time()-$timeout;
        $order=Order::where('uid',Auth::id())->where('ordered_time','>',$mintime)->where('ordered',0)->orderBy('id','desc')->first();
        if($order){
            $time_refresh=Order::find($order->id);
            $time_refresh->save();
            $_order=$order;
        }
        else{
            $_order=new Order;
            $_order->uid=Auth::id();
            $_order->ordered_time=time();
            $_order->save();
        }
        $new_item=new Item;
        $new_item->orderID=$_order->id;
        $new_item->itemid=request('id');
        $new_item->quantity=request('q');
        $new_item->save();
    });

    Route::post('/deleteitem',function(){
        $db_item=Item::find(request('id'));
        $db_order=Order::find($db_item->orderID);
        $items_in_order=Item::where('orderID',$db_item->orderID)->count();
        if($db_order->uid==Auth::id()){
            $db_item->delete();
            if($items_in_order<2)
                $db_order->delete();
        }
        else return false;
    });

    Route::post('/deleteorder',function(){
        $db_order=Order::find(request('id'));
        if($db_order->uid==Auth::id())
            $db_order->delete();
        else return false;
    });

    Route::post('/confirmorder',function(){
        $db_order=Order::find(request('id'));
        $addr=request('addr');
        if($db_order->uid==Auth::id() and strlen($addr)){
            $db_order->address=$addr;
            $db_order->confirmed_time=time();
            $db_order->ordered=1;
            $db_order->save();
        }
        else return false;
    });

});

Route::get('/about',function(){
    return view('about');
});
