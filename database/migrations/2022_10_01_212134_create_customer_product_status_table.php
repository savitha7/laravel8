<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerProductStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('customer_product_status')) {
            Schema::create('customer_product_status', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('customer_product_id')->unsigned()->index()->nullable();
                $table->foreign('customer_product_id')->references('id')->on('customer_product')->onDelete('set null');
                $table->bigInteger('product_step_id')->unsigned()->index()->nullable();
                $table->foreign('product_step_id')->references('id')->on('product_step')->onDelete('set null');
                $table->bigInteger('status_id')->unsigned()->index()->nullable();
                $table->foreign('status_id')->references('id')->on('status')->onDelete('set null');
                $table->timestamps();
            });

            Schema::table('customer_product', function($table) {
                $table->foreign('final_status')->references('status_id')->on('customer_product_status')->onDelete('set null');
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
        Schema::dropIfExists('customer_product_status');
    }
}
