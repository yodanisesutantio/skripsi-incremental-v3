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
        Schema::create('instructor_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificatePath');
            $table->date('startCertificateDate');
            $table->date('endCertificateDate');
            $table->string('certificateStatus')->default('Belum Divalidasi');
            $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructor_certificates');
    }
};
