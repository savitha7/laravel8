<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerProductDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('customer_product_document')) {
            Schema::create('customer_product_document', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('customer_product_status_id')->unsigned()->index()->nullable();
                $table->foreign('customer_product_status_id')->references('id')->on('customer_product_status')->onDelete('set null');
                $table->string('document_name');
                $table->string('document_name_enycript');
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
        Schema::dropIfExists('customer_product_document');
    }
}
