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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade'); // Instructor ID
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade'); // Student ID
            $table->string('student_real_name');
            $table->string('student_gender');
            $table->string('student_birth_of_place');
            $table->date('student_birth_of_date');
            $table->string('student_occupation');
            $table->string('student_phone_number');
            $table->string('student_address');
            $table->string('student_education_level');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
