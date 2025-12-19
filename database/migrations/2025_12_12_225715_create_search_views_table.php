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
        Schema::create('search_views', function (Blueprint $table) {
            $table->id();
            $table->string('query');
            $table->string('page')->nullable();
            $table->unsignedInteger('count')->default(0);
            $table->timestamps();

            $table->index('query');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_views');
    }
};
