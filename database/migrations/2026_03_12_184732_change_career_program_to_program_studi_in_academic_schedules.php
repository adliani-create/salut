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
        Schema::table('academic_schedules', function (Blueprint $table) {
            $table->dropForeign(['career_program_id']);
            $table->renameColumn('career_program_id', 'program_studi_id');
            $table->foreign('program_studi_id')->references('id')->on('program_studis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('academic_schedules', function (Blueprint $table) {
            $table->dropForeign(['program_studi_id']);
            $table->renameColumn('program_studi_id', 'career_program_id');
            $table->foreign('career_program_id')->references('id')->on('career_programs')->onDelete('cascade');
        });
    }
};
