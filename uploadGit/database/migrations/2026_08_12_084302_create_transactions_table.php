<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained(); // Relasi ke kasir yang login
        $table->string('invoice_no')->unique(); // Contoh: INV-20260812-001
        $table->integer('total_amount'); // Total belanja
        $table->enum('payment_method', ['Cash', 'QRIS'])->default('Cash');
        $table->integer('cash_received')->nullable(); // Uang yang dibayar
        $table->integer('change')->nullable(); // Kembalian
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
