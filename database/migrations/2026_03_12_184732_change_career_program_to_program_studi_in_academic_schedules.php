<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('academic_schedules', function (Blueprint $table) {
            if (Schema::hasColumn('academic_schedules', 'career_program_id')) {
                // Since the constraint was dropped but index might remain:
                try {
                    DB::statement("ALTER TABLE academic_schedules DROP INDEX academic_schedules_career_program_id_foreign");
                } catch (\Exception $e) {}
                
                $table->dropColumn('career_program_id');
            }
            if (!Schema::hasColumn('academic_schedules', 'prodi_id')) {
                $table->unsignedBigInteger('prodi_id')->nullable()->after('target_semester');
                $table->foreign('prodi_id')->references('id')->on('prodis')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('academic_schedules', function (Blueprint $table) {
            if (Schema::hasColumn('academic_schedules', 'prodi_id')) {
                try {
                    $table->dropForeign(['prodi_id']);
                } catch (\Exception $e) {}
                $table->dropColumn('prodi_id');
            }
            if (!Schema::hasColumn('academic_schedules', 'career_program_id')) {
                $table->unsignedBigInteger('career_program_id')->nullable();
                $table->foreign('career_program_id')->references('id')->on('career_programs')->onDelete('cascade');
            }
        });
    }
};
