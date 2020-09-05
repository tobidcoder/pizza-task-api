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
            $table->unsignedBigInteger('user_id');
            $table->string('order_id');
            $table->bigInteger('item_count');
            $table->decimal('total_amount_in_dollars', '20', '2');
            $table->decimal('total_amount_in_euros');
            $table->string('shipping_address');
            $table->decimal('shipping_fees', '20', 2);
            $table->string('phone_number', '15');
            $table->timestamps();
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
