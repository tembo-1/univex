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
        Schema::create('mailing_campaigns', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mailing_status_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('name');                     // "Новогодняя распродажа 2024"
            $table->string('subject');                  // Тема письма
            $table->text('content');                    // HTML контент

            $table->timestamp('scheduled_at')->nullable(); // Когда отправить
            $table->timestamp('sent_at')->nullable();      // Когда начали отправку
            $table->timestamp('completed_at')->nullable(); // Когда завершили
            $table->boolean('send_to_all')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mailing_campaigns');
    }
};
