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
        Schema::create('driving_school_licenses', function (Blueprint $table) {
            $table->id();
            $table->string('licensePath');
            $table->date('endLicenseDate');
            $table->string('licenseStatus');
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driving_school_licenses');
    }
};
