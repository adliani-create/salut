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
        Schema::create('course_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_record_id')->constrained()->onDelete('cascade');
            $table->string('course_code')->nullable();
            $table->string('course_name');
            $table->integer('sks');
            $table->string('grade_letter');
            $table->decimal('grade_point', 3, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_grades');
    }
};
