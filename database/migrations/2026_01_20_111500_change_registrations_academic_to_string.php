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
        Schema::table('registrations', function (Blueprint $table) {
            // Drop foreign keys first
            if (Schema::hasColumn('registrations', 'fakultas_id')) {
                $table->dropForeign(['fakultas_id']);
                $table->dropColumn('fakultas_id');
            }
            if (Schema::hasColumn('registrations', 'prodi_id')) {
                $table->dropForeign(['prodi_id']);
                $table->dropColumn('prodi_id');
            }

            // Add string columns
            $table->string('fakultas')->nullable()->after('jenjang');
            $table->string('prodi')->nullable()->after('fakultas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn(['fakultas', 'prodi']);
            
            // Re-add foreign keys (nullable as per previous state)
            $table->foreignId('fakultas_id')->nullable()->constrained('fakultas')->nullOnDelete();
            $table->foreignId('prodi_id')->nullable()->constrained('prodis')->nullOnDelete();
        });
    }
};
