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
        Schema::create('client_ledger_entry_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_ledger_entry_id')->constrained()->cascadeOnDelete();

            $table->unsignedInteger('line_no');

            $table->string('product_sku');
            $table->string('product_name');
            $table->unsignedBigInteger('quantity');
            $table->bigInteger('unit_price');
            $table->bigInteger('total_amount');

            $table->timestamps();

            $table->unique(['client_ledger_entry_id', 'line_no']);
            $table->index('product_sku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_ledger_entry_items');
    }
};
