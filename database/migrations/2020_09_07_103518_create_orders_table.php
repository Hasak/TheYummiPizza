<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('uid')->nullable();
            $table->unsignedBigInteger('ordered_time');
            $table->string('address')->nullable();
            $table->unsignedBigInteger('confirmed_time')->nullable();
            $table->boolean('ordered')->default(false);
        });

        Schema::table('orders', function(Blueprint $table){
            $table->foreign('uid')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
