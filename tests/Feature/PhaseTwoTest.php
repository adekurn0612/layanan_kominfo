<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhaseTwoTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeded_services_are_visible_in_admin_and_user_catalog(): void
    {
        $this->seed();

        $admin = User::where('email', 'admin@pemda.test')->firstOrFail();

        $this->actingAs($admin)
            ->get('/admin/services')
            ->assertOk()
            ->assertSee('Pembuatan Website Desa')
            ->assertSee('Permintaan Akses Internet')
            ->assertSee('Permintaan Hosting');

        $this->actingAs($admin)
            ->get('/services')
            ->assertOk()
            ->assertSee('Aplikasi dan Website')
            ->assertSee('images/service-categories/aplikasi-website.svg')
            ->assertSee('Permintaan Hosting');
    }

    public function test_guest_can_view_catalog_and_requirements_but_must_login_to_apply(): void
    {
        $this->seed();

        $service = Service::where('code', 'permintaan-hosting')->firstOrFail();

        $this->get('/services')
            ->assertOk()
            ->assertSee('Katalog Layanan Publik')
            ->assertSee('Permintaan Hosting');

        $this->get(route('services.show', $service))
            ->assertOk()
            ->assertSee('Dokumen permohonan hosting')
            ->assertSee('Login diperlukan saat mengajukan layanan.');

        $this->get(route('services.apply', $service))
            ->assertRedirect(route('login'));

        $this->post(route('services.apply.store', $service))
            ->assertRedirect(route('login'));
    }

    public function test_dynamic_service_form_validates_from_database_fields(): void
    {
        $this->seed();

        $admin = User::where('email', 'admin@pemda.test')->firstOrFail();
        $service = Service::where('code', 'permintaan-hosting')->firstOrFail();

        $this->actingAs($admin)
            ->post(route('services.apply.store', $service), [])
            ->assertSessionHasErrors([
                'fields.nama_aplikasi',
                'fields.domain',
                'fields.platform',
                'fields.kebutuhan_storage',
                'fields.kebutuhan_database',
            ]);

        $response = $this->actingAs($admin)
            ->post(route('services.apply.store', $service), [
                'fields' => [
                    'nama_aplikasi' => 'Portal Desa',
                    'domain' => 'portal-desa.example.go.id',
                    'platform' => 'Laravel',
                    'kebutuhan_storage' => '10 GB',
                    'kebutuhan_database' => 'PostgreSQL',
                    'catatan_teknis' => 'Butuh PHP 8.2',
                ],
            ]);

        $ticket = Ticket::firstOrFail();

        $response
            ->assertRedirect(route('tickets.lookup', ['uuid' => $ticket->uuid]))
            ->assertSessionHas('status');

        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
            $ticket->uuid
        );

        $this->assertSame('submitted', $ticket->status);
        $this->assertSame('Portal Desa', $ticket->form_data['nama_aplikasi']);

        $this->get(route('tickets.lookup', ['uuid' => $ticket->uuid]))
            ->assertOk()
            ->assertSee($ticket->uuid)
            ->assertSee('Permintaan Hosting');
    }
}
