<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    public function itemid(){
        return $this->belongsTo("App\Menu","itemID");
    }
    public function orderid(){
        return $this->belongsTo("App\Order","orderID");
    }
    protected $table="cart";
}
