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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('payment_name');
            $table->string('payment_receiver_name');
            $table->string('payment_address');
            $table->date('expiration_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    // use Illuminate\Support\Facades\Crypt;

    // $encryptedCardNumber = Crypt::encryptString($cardNumber);
    // $decryptedCardNumber = Crypt::decryptString($encryptedCardNumber);

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
