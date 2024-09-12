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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('username')->unique();
            $table->string('phone_number', 20)->unique();
            $table->string('password');
            $table->string('role')->default('user');
            $table->integer('age')->nullable();
            $table->string('description')->nullable();
            $table->string('hash_for_profile_picture')->nullable();
            $table->time('open_hours_for_admin')->nullable();
            $table->time('close_hours_for_admin')->nullable();
            $table->boolean('availability')->default(true);
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
