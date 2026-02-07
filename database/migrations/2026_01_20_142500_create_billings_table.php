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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('billing_code')->unique(); // e.g., INV-202601-572
            $table->string('category'); // 'UKT', 'Layanan SALUT', 'SPI', etc.
            $table->decimal('amount', 15, 2);
            $table->integer('semester')->nullable();
            $table->enum('status', ['unpaid', 'pending', 'paid', 'failed'])->default('unpaid');
            $table->date('due_date')->nullable();
            $table->string('payment_proof')->nullable();
            $table->timestamp('payment_date')->nullable(); // When proof uploaded
            $table->timestamp('verified_at')->nullable(); // When admin approved
            $table->text('rejection_reason')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};
