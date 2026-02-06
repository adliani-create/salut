<?php

namespace Tests\Unit\Middleware;

use App\Http\Middleware\IsAdmin;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class IsAdminTest extends TestCase
{
    use DatabaseTransactions;

    protected $middleware;

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

        $this->middleware = new IsAdmin();
    }

    public function test_allows_access_for_admin_user()
    {
        $adminRole = Role::factory()->create(['name' => 'admin']);
        $user = User::factory()->create(['role_id' => $adminRole->id]);

        $this->actingAs($user);

        $request = Request::create('/admin/dashboard', 'GET');
        $response = $this->middleware->handle($request, function ($req) {
            return new Response('Admin Dashboard');
        });

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Admin Dashboard', $response->getContent());
    }

    public function test_denies_access_for_non_admin_user()
    {
        $mahasiswaRole = Role::factory()->create(['name' => 'mahasiswa']);
        $user = User::factory()->create(['role_id' => $mahasiswaRole->id]);

        $this->actingAs($user);

        $request = Request::create('/admin/dashboard', 'GET');
        $response = $this->middleware->handle($request, function ($req) {
            return new Response('Admin Dashboard');
        });

        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test_redirects_to_login_when_user_not_authenticated()
    {
        $request = Request::create('/admin/dashboard', 'GET');
        $response = $this->middleware->handle($request, function ($req) {
            return new Response('Admin Dashboard');
        });

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test_denies_access_for_user_with_no_role()
    {
        $user = User::factory()->create(['role_id' => null]);

        $this->actingAs($user);

        $request = Request::create('/admin/dashboard', 'GET');
        $response = $this->middleware->handle($request, function ($req) {
            return new Response('Admin Dashboard');
        });

        $this->assertEquals(302, $response->getStatusCode());
    }
}
