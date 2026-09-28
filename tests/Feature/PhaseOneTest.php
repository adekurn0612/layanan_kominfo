<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\Role;
use App\Models\Service;
use App\Models\Ticket;
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

    public function test_dashboard_shows_sla_kpis(): void
    {
        $this->seed();

        $admin = User::where('email', 'admin@pemda.test')->firstOrFail();

        $service = Service::create([
            'category_id' => 1,
            'name' => 'Pelayanan Digital',
            'code' => 'pelayanan-digital',
            'description' => 'Service test',
            'sla_hours' => 24,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Ticket::create([
            'service_id' => $service->id,
            'user_id' => $admin->id,
            'organization_id' => $admin->organization_id,
            'status' => 'completed',
            'submitted_at' => now()->subHours(20),
            'target_deadline_at' => now()->subHours(20)->addHours(24),
            'first_response_at' => now()->subHours(18),
            'resolved_at' => now()->subHours(6),
            'sla_status' => 'on_time',
            'sla_breached' => false,
            'priority' => 'medium',
            'response_hours' => 2,
            'resolution_hours' => 14,
        ]);

        $this->actingAs($admin)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Pemenuhan SLA')
            ->assertSee('Tepat Waktu')
            ->assertSee('Melampaui SLA')
            ->assertSee('Jumlah Semua Pengajuan')
            ->assertSee('Diproses')
            ->assertSee('Gagal/Ditolak');
    }
}
