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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('bank_name');                    // Название банка
            $table->string('bik');                          // БИК
            $table->string('payment_account');               // Расчётный счёт
            $table->string('correspondent_account')->nullable(); // Корреспондентский счёт
            $table->boolean('is_default')->default(true);  // Основной счёт
            $table->timestamps();

            $table->index('client_id');
            $table->index('bik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
