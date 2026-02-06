<?php

namespace Tests\Unit;

use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Manually create the roles table for testing
        Schema::create('roles', function ($table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label');
            $table->string('redirect_to')->default('home');
            $table->timestamps();
        });
    }

    public function test_role_fillable_attributes()
    {
        $role = new Role();

        $this->assertContains('name', $role->getFillable());
        $this->assertContains('label', $role->getFillable());
        $this->assertContains('redirect_to', $role->getFillable());
    }

    public function test_role_can_be_created()
    {
        $roleData = [
            'name' => 'admin',
            'label' => 'Administrator',
            'redirect_to' => 'admin.dashboard',
        ];

        $role = Role::create($roleData);

        $this->assertInstanceOf(Role::class, $role);
        $this->assertEquals('admin', $role->name);
        $this->assertEquals('Administrator', $role->label);
        $this->assertEquals('admin.dashboard', $role->redirect_to);
    }

    public function test_role_factory_creates_valid_role()
    {
        $role = Role::factory()->create();

        $this->assertInstanceOf(Role::class, $role);
        $this->assertNotNull($role->name);
        $this->assertNotNull($role->label);
        $this->assertNotNull($role->redirect_to);
    }

    public function test_admin_role_factory_state()
    {
        $role = Role::factory()->admin()->create();

        $this->assertEquals('admin', $role->name);
        $this->assertEquals('Administrator', $role->label);
        $this->assertEquals('admin.dashboard', $role->redirect_to);
    }

    public function test_mahasiswa_role_factory_state()
    {
        $role = Role::factory()->mahasiswa()->create();

        $this->assertEquals('mahasiswa', $role->name);
        $this->assertEquals('Mahasiswa', $role->label);
        $this->assertEquals('home', $role->redirect_to);
    }

    public function test_mitra_role_factory_state()
    {
        $role = Role::factory()->mitra()->create();

        $this->assertEquals('mitra', $role->name);
        $this->assertEquals('Mitra', $role->label);
        $this->assertEquals('home', $role->redirect_to);
    }

    public function test_affiliator_role_factory_state()
    {
        $role = Role::factory()->affiliator()->create();

        $this->assertEquals('affiliator', $role->name);
        $this->assertEquals('Affiliator', $role->label);
        $this->assertEquals('home', $role->redirect_to);
    }
}
