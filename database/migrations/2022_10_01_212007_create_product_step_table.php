<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductStepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('product_step')) {
            Schema::create('product_step', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('product_id')->unsigned()->index()->nullable();
                $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
                $table->bigInteger('step_id')->unsigned()->index()->nullable();
                $table->foreign('step_id')->references('id')->on('step')->onDelete('set null');
                $table->integer('sequence');
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
        Schema::dropIfExists('product_step');
    }
}
