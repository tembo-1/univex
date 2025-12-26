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
            $table->foreignId('client_ledger_entry_type_id')->constrained();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('entry_no');        // entryNo
            $table->string('document_no');     // documentNo
            $table->timestamp('posting_date')->nullable();  // postingDate
            $table->timestamp('due_date')->nullable();      // dueDate
            $table->boolean('positive')->default(true);     // positive
            $table->boolean('open')->default(true);         // open
            $table->bigInteger('amount');                   // amount
            $table->bigInteger('remaining_amount');         // remainingAmount

            $table->timestamps();

            // ✅ Уникальный ключ для синхронизации
            $table->unique(['user_id', 'entry_no']);
            $table->index(['user_id', 'open']);
            $table->index('posting_date');
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
