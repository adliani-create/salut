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
            $table->string('whatsapp')->nullable()->after('user_id');
            $table->enum('jenjang', ['S1', 'S2'])->nullable()->after('whatsapp');
            $table->foreignId('fakultas_id')->nullable()->constrained('fakultas')->nullOnDelete()->after('jenjang');
            $table->foreignId('prodi_id')->nullable()->constrained('prodis')->nullOnDelete()->after('fakultas_id');
            $table->enum('jalur_pendaftaran', ['Reguler', 'RPL'])->nullable()->after('prodi_id');
            
            // Modify existing columns
            $table->text('files')->nullable()->change();
            
            // Add draft status if not exists (modifying enum is tricky in some DBs, assuming status is enum)
            // For safety in Laravel migrations on existing data, we might need DB statement for enum modification
            // But here we can just ensure the default creation handles 'draft' in logic, or use text field. 
            // Since 'status' is enum ['pending', 'valid', 'invalid'], adding 'draft' requires raw statement or table alteration.
            // Let's stick to using 'pending' but check for null fields, OR allow 'draft'.
            // For simplicity/compatibility, we will try to modify column if possible, or just manage logic.
            // Let's try raw statement for MySQL.
        });

        // Modifying enum to add 'draft'
        DB::statement("ALTER TABLE registrations MODIFY COLUMN status ENUM('draft', 'pending', 'valid', 'invalid') DEFAULT 'draft'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropForeign(['fakultas_id']);
            $table->dropForeign(['prodi_id']);
            $table->dropColumn(['whatsapp', 'jenjang', 'fakultas_id', 'prodi_id', 'jalur_pendaftaran']);
            $table->text('files')->nullable(false)->change();
        });
        
        // Revert enum
        DB::statement("ALTER TABLE registrations MODIFY COLUMN status ENUM('pending', 'valid', 'invalid') DEFAULT 'pending'");
    }
};
