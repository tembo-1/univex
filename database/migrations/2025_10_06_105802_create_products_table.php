<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // description
            $table->string('sku'); // no - артикул
            $table->string('oem')->nullable(); // origNo - оригинальный номер
            $table->text('search_text')->nullable(); // matchCode - для поиска
            $table->boolean('on_sale')->default(false); // sale
            $table->decimal('sale_discount', 5, 2)->default(0); // sDiscount
            $table->integer('min_order_quantity')->default(1); // minQty

            $table->foreignId('manufacturer_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('product_warehouse_status_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();

            $table->string('code');
            $table->string('price_code');

            $table->index('code');
            $table->index('price_code');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
