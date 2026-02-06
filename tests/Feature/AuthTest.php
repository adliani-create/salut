<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AuthTest extends TestCase
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

        // Create sessions table for session-based authentication
        Schema::create('sessions', function ($table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Create roles for testing
        Role::create(['name' => 'mahasiswa', 'label' => 'Mahasiswa', 'redirect_to' => 'home']);
        Role::create(['name' => 'admin', 'label' => 'Administrator', 'redirect_to' => 'admin.dashboard']);
        Role::create(['name' => 'mitra', 'label' => 'Mitra', 'redirect_to' => 'home']);
        Role::create(['name' => 'affiliator', 'label' => 'Affiliator', 'redirect_to' => 'home']);
    }

    public function test_user_can_register()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/register', $userData);

        $response->assertRedirect('/home');
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $user = User::where('email', 'test@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('mahasiswa', $user->role->name);
    }

    public function test_user_registration_validation_fails_with_invalid_data()
    {
        $invalidData = [
            'name' => '',
            'email' => 'invalid-email',
            'password' => '123',
            'password_confirmation' => '456',
        ];

        $response = $this->post('/register', $invalidData);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function test_user_can_login_with_correct_credentials()
    {
        $mahasiswaRole = Role::where('name', 'mahasiswa')->first();
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
            'role_id' => $mahasiswaRole->id,
        ]);

        $loginData = [
            'email' => 'user@example.com',
            'password' => 'password123',
        ];

        $response = $this->post('/login', $loginData);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_incorrect_credentials()
    {
        $mahasiswaRole = Role::where('name', 'mahasiswa')->first();
        User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
            'role_id' => $mahasiswaRole->id,
        ]);

        $loginData = [
            'email' => 'user@example.com',
            'password' => 'wrongpassword',
        ];

        $response = $this->post('/login', $loginData);

        $response->assertRedirect();
        $this->assertGuest();
    }

    public function test_admin_user_is_redirected_to_admin_dashboard_after_login()
    {
        $adminRole = Role::where('name', 'admin')->first();
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'role_id' => $adminRole->id,
        ]);

        $loginData = [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ];

        $response = $this->post('/login', $loginData);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_can_logout()
    {
        $mahasiswaRole = Role::where('name', 'mahasiswa')->first();
        $user = User::factory()->create(['role_id' => $mahasiswaRole->id]);

        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_guest_cannot_access_protected_routes()
    {
        $response = $this->get('/home');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_home()
    {
        $mahasiswaRole = Role::where('name', 'mahasiswa')->first();
        $user = User::factory()->create(['role_id' => $mahasiswaRole->id]);

        $this->actingAs($user);

        $response = $this->get('/home');

        $response->assertStatus(200);
    }

    public function test_admin_can_access_admin_routes()
    {
        $adminRole = Role::where('name', 'admin')->first();
        $user = User::factory()->create(['role_id' => $adminRole->id]);

        $this->actingAs($user);

        $response = $this->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_access_admin_routes()
    {
        $mahasiswaRole = Role::where('name', 'mahasiswa')->first();
        $user = User::factory()->create(['role_id' => $mahasiswaRole->id]);

        $this->actingAs($user);

        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/home');
        $response->assertSessionHas('error', 'You do not have admin access.');
    }

    public function test_mitra_can_access_mitra_routes()
    {
        $mitraRole = Role::where('name', 'mitra')->first();
        $user = User::factory()->create(['role_id' => $mitraRole->id]);

        $this->actingAs($user);

        $response = $this->get('/mitra/dashboard');

        $response->assertStatus(200);
    }

    public function test_affiliator_can_access_affiliator_routes()
    {
        $affiliatorRole = Role::where('name', 'affiliator')->first();
        $user = User::factory()->create(['role_id' => $affiliatorRole->id]);

        $this->actingAs($user);

        $response = $this->get('/affiliator/dashboard');

        $response->assertStatus(200);
    }
}
