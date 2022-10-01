<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('customer_product')) {
            Schema::create('customer_product', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('customer_id')->unsigned()->index()->nullable();
                $table->foreign('customer_id')->references('id')->on('customer')->onDelete('set null');
                $table->bigInteger('product_id')->unsigned()->index()->nullable();
                $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
                $table->bigInteger('final_status')->unsigned()->index()->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_product');
    }
}
