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
            $table->string('slug')->unique()->nullable();
            $table->longText('description')->nullable();
            $table->boolean('visibility');
            $table->date('availability');
            $table->decimal('price', 10, 2);
            $table->decimal('compare_at_price', 10, 2);
            $table->decimal('cost_per_item', 10, 2);
            $table->integer('sku')->unique()->nullable();
            $table->integer('barcode')->unique()->nullable();
            $table->integer('quantity');
            $table->integer('security_stock');
            $table->boolean('returnable')->nullable();
            $table->boolean('shipped')->nullable();
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
