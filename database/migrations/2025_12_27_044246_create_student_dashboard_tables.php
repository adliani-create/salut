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
        // Academic Records
        Schema::create('academic_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('semester'); // e.g., '2024.1'
            $table->integer('sks');
            $table->decimal('ipk', 3, 2)->nullable();
            $table->decimal('ips', 3, 2)->nullable();
            $table->timestamps();
        });

        // Tutorial Schedules
        Schema::create('tutorial_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('course_name');
            $table->string('day'); // Monday, etc.
            $table->time('time');
            $table->string('link')->nullable(); // Zoom link or location
            $table->timestamps();
        });

        // Student Tracks (Non-Academic)
        Schema::create('student_tracks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('track_name'); // Magang, Skill Academy, etc.
            $table->timestamp('selected_at');
            $table->timestamps();
        });

        // Invoices (Finance)
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title'); // UKT, Biaya Layanan, Admisi
            $table->decimal('amount', 12, 2);
            $table->string('status')->default('unpaid'); // unpaid, paid, cancelled
            $table->date('due_date');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('student_tracks');
        Schema::dropIfExists('tutorial_schedules');
        Schema::dropIfExists('academic_records');
    }
};
