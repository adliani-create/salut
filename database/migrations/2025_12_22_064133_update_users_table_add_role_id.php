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
        // 1. Add role_id column (nullable first)
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->after('id')->constrained('roles')->onDelete('set null');
        });

        // 2. Seed Roles
        $roles = [
            ['name' => 'admin', 'label' => 'Administrator', 'redirect_to' => 'admin.dashboard'],
            ['name' => 'mahasiswa', 'label' => 'Mahasiswa', 'redirect_to' => 'home'],
            ['name' => 'yayasan', 'label' => 'Yayasan', 'redirect_to' => 'yayasan.dashboard'],
            ['name' => 'staff', 'label' => 'Staff', 'redirect_to' => 'staff.dashboard'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insertOrIgnore(array_merge($role, ['created_at' => now(), 'updated_at' => now()]));
        }

        // 3. Migrate Data
        $rolesData = DB::table('roles')->pluck('id', 'name'); // ['admin' => 1, ...]

        foreach ($rolesData as $name => $id) {
            DB::table('users')->where('role', $name)->update(['role_id' => $id]);
        }
        
        // Handle any users with 'user' role mapping to 'mahasiswa' just in case
        if (isset($rolesData['mahasiswa'])) {
             DB::table('users')->where('role', 'user')->update(['role_id' => $rolesData['mahasiswa']]);
        }

        // 4. Drop old role column and make role_id required (if desired, or keep nullable for safety)
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            // $table->foreignId('role_id')->nullable(false)->change(); // Optional: Make strict later
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('mahasiswa')->after('email');
        });

        // Restore data (Reverse logic)
        $rolesData = DB::table('roles')->pluck('name', 'id');
        
        $users = DB::table('users')->whereNotNull('role_id')->get();
        foreach($users as $user){
            if(isset($rolesData[$user->role_id])){
                 DB::table('users')->where('id', $user->id)->update(['role' => $rolesData[$user->role_id]]);
            }
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
};
