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
    public function up()
    {
        try {
            Schema::table('academic_schedules', function (Blueprint $table) {
                // Hapus foreign key-nya secara terpisah untuk bisa di try-catch
                $table->dropForeign(['career_program_id']); 
            });
        } catch (\Exception $e) {
            // Abaikan jika foreign key tidak ada atau sudah terhapus
        }
        
        Schema::table('academic_schedules', function (Blueprint $table) {
            if (Schema::hasColumn('academic_schedules', 'career_program_id')) {
                $table->dropColumn('career_program_id');
            }
            if (!Schema::hasColumn('academic_schedules', 'prodi_id')) {
                $table->foreignId('prodi_id')->nullable()->constrained('prodis')->nullOnDelete(); 
            } 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            Schema::table('academic_schedules', function (Blueprint $table) {
                $table->dropForeign(['prodi_id']);
            });
        } catch (\Exception $e) {}

        Schema::table('academic_schedules', function (Blueprint $table) {
            if (Schema::hasColumn('academic_schedules', 'prodi_id')) {
                $table->dropColumn('prodi_id');
            }
            if (!Schema::hasColumn('academic_schedules', 'career_program_id')) {
                $table->unsignedBigInteger('career_program_id')->nullable();
                $table->foreign('career_program_id')->references('id')->on('career_programs')->onDelete('cascade');
            }
        });
    }
};
