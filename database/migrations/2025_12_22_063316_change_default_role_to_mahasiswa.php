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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('mahasiswa')->change();
        });

        // Update existing 'user' roles to 'mahasiswa'
        DB::table('users')->where('role', 'user')->update(['role' => 'mahasiswa']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert 'mahasiswa' back to 'user' (optional, dependent on data policy)
        DB::table('users')->where('role', 'mahasiswa')->update(['role' => 'user']);

        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->change();
        });
    }
};
