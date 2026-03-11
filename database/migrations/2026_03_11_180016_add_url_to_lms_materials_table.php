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
        Schema::table('lms_materials', function (Blueprint $table) {
            $table->string('file_path')->nullable()->change();
            $table->string('url')->nullable()->after('file_path');
            $table->string('source_type')->nullable()->default('local')->after('url'); // e.g., 'youtube', 'gdrive', 'local'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lms_materials', function (Blueprint $table) {
            $table->string('file_path')->nullable(false)->change();
            $table->dropColumn(['url', 'source_type']);
        });
    }
};
