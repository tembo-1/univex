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
            $table->foreignId('mailing_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('name');                     // "Новогодняя распродажа 2024"
            $table->string('subject');                  // Тема письма
            $table->text('content');                    // HTML контент

            $table->timestamp('scheduled_at')->nullable(); // Когда отправить
            $table->unsignedInteger('send_again_after')->nullable();
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
