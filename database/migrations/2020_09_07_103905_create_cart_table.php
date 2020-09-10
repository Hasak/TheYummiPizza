<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('orderID')->nullable();
            $table->unsignedBigInteger('itemID')->nullable();
            $table->unsignedInteger('quantity');
        });

        Schema::table('cart',function(Blueprint $table){
            $table->foreign('orderID')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('itemID')->references('id')->on('menu')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart');
    }
}
