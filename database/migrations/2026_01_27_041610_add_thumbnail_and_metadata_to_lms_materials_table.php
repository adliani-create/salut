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
            $table->string('thumbnail')->nullable()->after('type'); // Path to image
            $table->string('duration')->nullable()->after('thumbnail'); // e.g. "10 Menit", "15 Halaman"
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lms_materials', function (Blueprint $table) {
            $table->dropColumn(['thumbnail', 'duration']);
        });
    }
};
