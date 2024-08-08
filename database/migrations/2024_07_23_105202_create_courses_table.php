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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_name');
            $table->string('course_description');
            $table->string('course_thumbnail')->nullable();
            $table->integer('course_quota');
            $table->integer('course_price');
            $table->integer('course_duration');
            $table->integer('course_length');
            $table->string('car_type');
            $table->boolean('can_use_own_car')->default(false);
            $table->boolean('course_availability')->default(true);
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
