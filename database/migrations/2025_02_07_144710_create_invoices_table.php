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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 20)->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('customer_name')->nullable(); // Nama pengirim (untuk Stock Out)
            $table->string('receiver_name')->nullable(); // Nama penerima (untuk Stock In)
            $table->decimal('total_amount', 12, 2);
            $table->timestamp('date')->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
