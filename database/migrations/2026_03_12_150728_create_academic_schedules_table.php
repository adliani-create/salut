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
        Schema::create('academic_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['tugas', 'diskusi', 'tuweb', 'ujian']);
            $table->date('date');
            $table->time('time');
            $table->dateTime('deadline')->nullable();
            
            // Filters
            $table->string('target_semester')->nullable(); // e.g '1', '2', or null for all
            $table->foreignId('career_program_id')->nullable()->constrained()->nullOnDelete();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_schedules');
    }
};
