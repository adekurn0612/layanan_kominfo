<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhaseOneTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeded_admin_can_access_dashboard_and_organization_index(): void
    {
        $this->seed();

        $admin = User::where('email', 'admin@pemda.test')->firstOrFail();

        $this->actingAs($admin)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Dashboard layanan aktif');

        $this->actingAs($admin)
            ->get('/admin/organizations')
            ->assertOk()
            ->assertSee('Dinas Kominfo');
    }

    public function test_user_without_admin_permission_cannot_access_admin_panel(): void
    {
        $organization = Organization::create([
            'code' => 'UNIT',
            'name' => 'Unit Kerja',
            'type' => 'opd',
            'is_active' => true,
        ]);

        $role = Role::create([
            'name' => 'Pemohon/User',
            'code' => 'pemohon-user',
            'is_active' => true,
        ]);

        $user = User::create([
            'organization_id' => $organization->id,
            'name' => 'Pemohon',
            'email' => 'pemohon@example.test',
            'password' => 'password',
            'is_active' => true,
        ]);

        $user->roles()->attach($role);

        $this->actingAs($user)
            ->get('/admin/organizations')
            ->assertForbidden();
    }
}
