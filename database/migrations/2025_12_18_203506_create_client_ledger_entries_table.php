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
        Schema::create('client_ledger_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_ledger_entry_type_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('entry_number'); // номер операции клиента
            $table->timestamp('posting_date')->nullable(); // дата операции
            $table->string('document_no')->nullable(); // номер документа
            $table->timestamp('due_date')->nullable(); // дата оплаты (для счета)
            $table->boolean('positive')->default(true); // положительная операция с точки зрения клиента
            $table->boolean('open')->default(true); // открытая (не примененная) операция
            $table->bigInteger('amount'); // сумма операции
            $table->bigInteger('remaining_amount')->default(0); // остаточная сумма
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_ledger_entries');
    }
};
