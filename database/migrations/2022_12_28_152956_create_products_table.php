<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->integer('visibility');
            $table->date('availability');
            $table->json('brands')->nullable();
            $table->json('categories');
            $table->integer('price');
            $table->integer('compare_at_price');
            $table->integer('cost_per_item');
            $table->integer('sku');
            $table->integer('barcode');
            $table->integer('quantity');
            $table->integer('security_stock');
            $table->integer('returnable')->nullable();
            $table->integer('shipped')->nullable();
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
        Schema::dropIfExists('products');
    }
};
