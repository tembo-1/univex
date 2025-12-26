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
        Schema::create('product_originals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('manufacturer_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('oem');
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();

            $table->index(['manufacturer_id', 'oem']);
            $table->index('product_id');

            $table->unique(['product_id', 'manufacturer_id', 'oem']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_originals');
    }
};
