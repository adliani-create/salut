<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Manually create the necessary tables for testing
        Schema::create('roles', function ($table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label');
            $table->string('redirect_to')->default('home');
            $table->timestamps();
        });

        Schema::create('users', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function test_user_belongs_to_role()
    {
        $role = Role::factory()->create();
        $user = User::factory()->create(['role_id' => $role->id]);

        $this->assertInstanceOf(Role::class, $user->role);
        $this->assertEquals($role->id, $user->role->id);
    }

    public function test_is_admin_returns_true_for_admin_user()
    {
        $adminRole = Role::factory()->create(['name' => 'admin']);
        $user = User::factory()->create(['role_id' => $adminRole->id]);

        $this->assertTrue($user->isAdmin());
    }

    public function test_is_admin_returns_false_for_non_admin_user()
    {
        $mahasiswaRole = Role::factory()->create(['name' => 'mahasiswa']);
        $user = User::factory()->create(['role_id' => $mahasiswaRole->id]);

        $this->assertFalse($user->isAdmin());
    }

    public function test_is_admin_returns_false_when_user_has_no_role()
    {
        $user = User::factory()->create(['role_id' => null]);

        $this->assertFalse($user->isAdmin());
    }

    public function test_is_mahasiswa_returns_true_for_mahasiswa_user()
    {
        $mahasiswaRole = Role::factory()->create(['name' => 'mahasiswa']);
        $user = User::factory()->create(['role_id' => $mahasiswaRole->id]);

        $this->assertTrue($user->isMahasiswa());
    }

    public function test_is_mahasiswa_returns_false_for_non_mahasiswa_user()
    {
        $adminRole = Role::factory()->create(['name' => 'admin']);
        $user = User::factory()->create(['role_id' => $adminRole->id]);

        $this->assertFalse($user->isMahasiswa());
    }

    public function test_is_mahasiswa_returns_false_when_user_has_no_role()
    {
        $user = User::factory()->create(['role_id' => null]);

        $this->assertFalse($user->isMahasiswa());
    }

    public function test_is_mitra_returns_true_for_mitra_user()
    {
        $mitraRole = Role::factory()->create(['name' => 'mitra']);
        $user = User::factory()->create(['role_id' => $mitraRole->id]);

        $this->assertTrue($user->isMitra());
    }

    public function test_is_mitra_returns_false_for_non_mitra_user()
    {
        $adminRole = Role::factory()->create(['name' => 'admin']);
        $user = User::factory()->create(['role_id' => $adminRole->id]);

        $this->assertFalse($user->isMitra());
    }

    public function test_is_mitra_returns_false_when_user_has_no_role()
    {
        $user = User::factory()->create(['role_id' => null]);

        $this->assertFalse($user->isMitra());
    }

    public function test_is_affiliator_returns_true_for_affiliator_user()
    {
        $affiliatorRole = Role::factory()->create(['name' => 'affiliator']);
        $user = User::factory()->create(['role_id' => $affiliatorRole->id]);

        $this->assertTrue($user->isAffiliator());
    }

    public function test_is_affiliator_returns_false_for_non_affiliator_user()
    {
        $adminRole = Role::factory()->create(['name' => 'admin']);
        $user = User::factory()->create(['role_id' => $adminRole->id]);

        $this->assertFalse($user->isAffiliator());
    }

    public function test_is_affiliator_returns_false_when_user_has_no_role()
    {
        $user = User::factory()->create(['role_id' => null]);

        $this->assertFalse($user->isAffiliator());
    }

    public function test_user_fillable_attributes()
    {
        $user = new User();

        $this->assertContains('name', $user->getFillable());
        $this->assertContains('email', $user->getFillable());
        $this->assertContains('password', $user->getFillable());
        $this->assertContains('role_id', $user->getFillable());
    }

    public function test_user_hidden_attributes()
    {
        $user = new User();

        $this->assertContains('password', $user->getHidden());
        $this->assertContains('remember_token', $user->getHidden());
    }

    public function test_user_casts()
    {
        $user = new User();

        $this->assertArrayHasKey('email_verified_at', $user->getCasts());
        $this->assertArrayHasKey('password', $user->getCasts());
        $this->assertEquals('datetime', $user->getCasts()['email_verified_at']);
        $this->assertEquals('hashed', $user->getCasts()['password']);
    }
}
