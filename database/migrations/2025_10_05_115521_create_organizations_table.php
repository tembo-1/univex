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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('client_status_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('employee_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('personal_discount', 5, 2)->default(0.00);       // Персональная скидка
            $table->string('name');                    // Полное наименование
            $table->string('short_name');              // Краткое наименование
            $table->string('inn');           // ИНН (уникальный)
            $table->string('kpp');                     // КПП
            $table->string('ogrn')->nullable();                    // ОГРН

            $table->string('marketing_email')->nullable();                    // ОГРН
            $table->string('is_send_price_list')->nullable();
            $table->string('is_send_bulk_price_list')->nullable();
            $table->string('payment_terms')->nullable();                    // ОГРН
            $table->boolean('is_store')->nullable();                    // ОГРН
            $table->string('agreement_number')->nullable();                    // ОГРН
            $table->timestamp('agreement_date')->nullable();                    // ОГРН

            $table->text('legal_address');             // Юридический адрес
            $table->text('postal_address')->nullable(); // Почтовый адрес
            $table->string('head_name')->nullable();               // ФИО руководителя
            $table->string('head_position')->nullable();           // Должность руководителя

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('phone')->nullable();           // Должность руководителя

            $table->string('edo_operator')->nullable();
            $table->string('edo_identifier')->nullable();

            $table->timestamps();

            $table->index('inn');
            $table->index('name');
            $table->index('client_status_id');
            $table->unique('user_id');
            $table->index('edo_operator');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
