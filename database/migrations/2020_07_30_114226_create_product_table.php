<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('category');
            $table->string('en_product_title')->nullable();
            $table->string('ar_product_title')->nullable();
            $table->text('en_product_description')->nullable();
            $table->text('ar_product_description')->nullable();
            $table->integer('en_product_price')->nullable();
            $table->string('ar_product_price')->nullable();
            $table->string('product_image_url')->nullable();
            $table->enum('product_status',['Active','Inactive'])->default('Active')->nullable();
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
        Schema::dropIfExists('product');
    }
}
