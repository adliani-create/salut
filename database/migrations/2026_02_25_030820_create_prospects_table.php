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
        Schema::create('prospects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliator_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('whatsapp');
            $table->string('school_origin')->nullable();
            $table->string('program_interest')->nullable();
            $table->enum('status', ['prospek', 'terdaftar', 'aktif'])->default('prospek');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prospects');
    }
};
