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
            $table->string('name');
            $table->string('sku');
            $table->string('oem')->nullable();
            $table->text('search_text')->nullable();
            $table->boolean('on_sale')->default(false);
            $table->decimal('sale_discount', 5, 2)->default(0);
            $table->integer('min_order_quantity')->default(1);

            $table->foreignId('manufacturer_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('product_warehouse_status_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();

            $table->string('code')->unique();

            $table->index('code');

            $table->index('manufacturer_id');
            $table->index('on_sale');
            $table->index('product_warehouse_status_id');

            $table->index(['manufacturer_id', 'on_sale']); // фильтр производителя + акция
            $table->index(['manufacturer_id', 'product_warehouse_status_id']); // фильтр производителя + статус

            $table->index(['sku']);

            // Полнотекстовый
            $table->fullText(['name', 'sku', 'oem', 'search_text']);
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
