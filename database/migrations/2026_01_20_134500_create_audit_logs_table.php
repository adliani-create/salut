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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Who performed the action (Admin)
            $table->string('action'); // e.g., "Updated Student"
            $table->string('target_model'); // e.g., "User", "Registration"
            $table->unsignedBigInteger('target_id'); // ID of the modified record
            $table->json('changes')->nullable(); // Store {old: val, new: val}
            $table->text('description')->nullable(); // Human readable description
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
