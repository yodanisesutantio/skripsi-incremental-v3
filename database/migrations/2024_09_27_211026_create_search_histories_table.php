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
        Schema::create('search_histories', function (Blueprint $table) {
            $table->id();
            // Foreign key for user
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('searchQuery');
            $table->timestamps();

            // Add a unique index for user_id and query combination
            $table->unique(['user_id', 'searchQuery']); // Ensure unique search queries per user
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_histories');
    }
};
