<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Organization;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permissions = collect([
            ['module' => 'Admin', 'name' => 'Akses Admin Panel', 'code' => 'admin.access'],
            ['module' => 'User', 'name' => 'Lihat User', 'code' => 'users.view'],
            ['module' => 'User', 'name' => 'Kelola User', 'code' => 'users.manage'],
            ['module' => 'Role', 'name' => 'Lihat Role', 'code' => 'roles.view'],
            ['module' => 'Role', 'name' => 'Kelola Role Permission', 'code' => 'roles.manage'],
            ['module' => 'Permission', 'name' => 'Lihat Permission', 'code' => 'permissions.view'],
            ['module' => 'Organisasi', 'name' => 'Lihat Organisasi', 'code' => 'organizations.view'],
            ['module' => 'Organisasi', 'name' => 'Kelola Organisasi', 'code' => 'organizations.manage'],
            ['module' => 'Kategori Layanan', 'name' => 'Lihat Kategori Layanan', 'code' => 'service-categories.view'],
            ['module' => 'Kategori Layanan', 'name' => 'Kelola Kategori Layanan', 'code' => 'service-categories.manage'],
            ['module' => 'Layanan', 'name' => 'Lihat Layanan', 'code' => 'services.view'],
            ['module' => 'Layanan', 'name' => 'Kelola Layanan', 'code' => 'services.manage'],
        ])->mapWithKeys(fn (array $permission) => [
            $permission['code'] => Permission::updateOrCreate(
                ['code' => $permission['code']],
                $permission
            ),
        ]);

        $roles = collect([
            ['name' => 'Super Admin', 'code' => 'super-admin', 'description' => 'Akses penuh sistem.'],
            ['name' => 'Admin Layanan', 'code' => 'admin-layanan', 'description' => 'Mengelola master layanan dan tiket.'],
            ['name' => 'Petugas/Teknisi', 'code' => 'petugas-teknisi', 'description' => 'Menangani tiket teknis.'],
            ['name' => 'Verifikator', 'code' => 'verifikator', 'description' => 'Memverifikasi permintaan layanan.'],
            ['name' => 'Pemohon/User', 'code' => 'pemohon-user', 'description' => 'Mengajukan dan memantau layanan.'],
        ])->mapWithKeys(fn (array $role) => [
            $role['code'] => Role::updateOrCreate(['code' => $role['code']], $role + ['is_active' => true]),
        ]);

        $roles['super-admin']->permissions()->sync($permissions->pluck('id'));
        $roles['admin-layanan']->permissions()->sync($permissions->only([
            'admin.access',
            'users.view',
            'roles.view',
            'permissions.view',
            'organizations.view',
            'organizations.manage',
            'service-categories.view',
            'service-categories.manage',
            'services.view',
            'services.manage',
        ])->pluck('id'));

        $pemkab = Organization::updateOrCreate(
            ['code' => 'PEMKAB'],
            ['name' => 'Pemerintah Kabupaten', 'type' => 'pemerintah_kabupaten', 'is_active' => true]
        );

        $kominfo = Organization::updateOrCreate(
            ['code' => 'DISKOMINFO'],
            ['parent_id' => $pemkab->id, 'name' => 'Dinas Kominfo', 'type' => 'opd', 'is_active' => true]
        );

        Organization::updateOrCreate(['code' => 'DISDIK'], ['parent_id' => $pemkab->id, 'name' => 'Dinas Pendidikan', 'type' => 'opd', 'is_active' => true]);
        Organization::updateOrCreate(['code' => 'DINKES'], ['parent_id' => $pemkab->id, 'name' => 'Dinas Kesehatan', 'type' => 'opd', 'is_active' => true]);

        $kecamatanA = Organization::updateOrCreate(['code' => 'KEC-A'], ['parent_id' => $pemkab->id, 'name' => 'Kecamatan A', 'type' => 'kecamatan', 'is_active' => true]);
        Organization::updateOrCreate(['code' => 'DESA-A'], ['parent_id' => $kecamatanA->id, 'name' => 'Desa A', 'type' => 'desa', 'is_active' => true]);
        Organization::updateOrCreate(['code' => 'DESA-B'], ['parent_id' => $kecamatanA->id, 'name' => 'Desa B', 'type' => 'desa', 'is_active' => true]);
        Organization::updateOrCreate(['code' => 'KEC-B'], ['parent_id' => $pemkab->id, 'name' => 'Kecamatan B', 'type' => 'kecamatan', 'is_active' => true]);

        $admin = User::updateOrCreate([
            'email' => 'admin@pemda.test',
        ], [
            'organization_id' => $kominfo->id,
            'name' => 'Super Admin',
            'password' => 'password',
            'is_active' => true,
        ]);

        $admin->roles()->sync([$roles['super-admin']->id]);

        $pemohon = User::updateOrCreate([
            'email' => 'pemohon@example.test',
        ], [
            'organization_id' => $kominfo->id,
            'name' => 'Pemohon User',
            'password' => 'password',
            'is_active' => true,
        ]);

        $pemohon->roles()->sync([$roles['pemohon-user']->id]);

        $infrastruktur = ServiceCategory::updateOrCreate(
            ['code' => 'infrastruktur-ti'],
            [
                'name' => 'Infrastruktur TI',
                'description' => 'Layanan jaringan, internet, hosting, server, dan domain.',
                'image_path' => 'images/service-categories/infrastruktur-ti.svg',
                'is_active' => true,
                'sort_order' => 10,
            ]
        );

        $aplikasi = ServiceCategory::updateOrCreate(
            ['code' => 'aplikasi-web'],
            [
                'name' => 'Aplikasi dan Website',
                'description' => 'Layanan pembuatan dan bantuan teknis aplikasi atau website.',
                'image_path' => 'images/service-categories/aplikasi-website.svg',
                'is_active' => true,
                'sort_order' => 20,
            ]
        );

        $websiteDesa = Service::updateOrCreate(
            ['code' => 'pembuatan-website-desa'],
            [
                'category_id' => $aplikasi->id,
                'name' => 'Pembuatan Website Desa',
                'description' => 'Pengajuan pembuatan website resmi desa beserta kebutuhan awal publikasi informasi desa.',
                'sla_hours' => 72,
                'is_active' => true,
                'sort_order' => 10,
            ]
        );

        $internet = Service::updateOrCreate(
            ['code' => 'permintaan-akses-internet'],
            [
                'category_id' => $infrastruktur->id,
                'name' => 'Permintaan Akses Internet',
                'description' => 'Pengajuan akses internet untuk OPD, kecamatan, desa, atau unit kerja lainnya.',
                'sla_hours' => 48,
                'is_active' => true,
                'sort_order' => 20,
            ]
        );

        $hosting = Service::updateOrCreate(
            ['code' => 'permintaan-hosting'],
            [
                'category_id' => $infrastruktur->id,
                'name' => 'Permintaan Hosting',
                'description' => 'Pengajuan fasilitas hosting untuk website atau aplikasi pemerintah daerah.',
                'sla_hours' => 24,
                'is_active' => true,
                'sort_order' => 30,
            ]
        );

        $this->seedFields($websiteDesa, [
            ['name' => 'nama_desa', 'label' => 'Nama Desa', 'type' => 'text', 'is_required' => true, 'sort_order' => 10],
            ['name' => 'kecamatan', 'label' => 'Kecamatan', 'type' => 'text', 'is_required' => true, 'sort_order' => 20],
            ['name' => 'nama_kepala_desa', 'label' => 'Nama Kepala Desa', 'type' => 'text', 'is_required' => true, 'sort_order' => 30],
            ['name' => 'nomor_hp', 'label' => 'Nomor HP', 'type' => 'phone', 'is_required' => true, 'sort_order' => 40],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'is_required' => true, 'sort_order' => 50],
            ['name' => 'domain', 'label' => 'Domain yang Diusulkan', 'type' => 'text', 'placeholder' => 'desa-example.go.id', 'is_required' => true, 'sort_order' => 60],
            ['name' => 'logo_desa', 'label' => 'Logo Desa', 'type' => 'file', 'is_required' => false, 'validation_rules' => ['mimes:jpg,jpeg,png', 'max:2048'], 'sort_order' => 70],
            ['name' => 'surat_permohonan', 'label' => 'Surat Permohonan', 'type' => 'file', 'is_required' => true, 'validation_rules' => ['mimes:pdf', 'max:4096'], 'sort_order' => 80],
        ]);

        $this->seedRequirements($websiteDesa, [
            ['name' => 'Surat permohonan resmi', 'description' => 'Surat ditandatangani kepala desa atau pejabat berwenang.', 'allowed_file_types' => ['pdf'], 'max_file_size' => 4096, 'sort_order' => 10],
            ['name' => 'Logo desa', 'description' => 'Logo untuk kebutuhan identitas website.', 'is_required' => false, 'allowed_file_types' => ['jpg', 'jpeg', 'png'], 'max_file_size' => 2048, 'sort_order' => 20],
        ]);

        $this->seedFields($internet, [
            ['name' => 'nama_opd', 'label' => 'Nama OPD/Unit Kerja', 'type' => 'text', 'is_required' => true, 'sort_order' => 10],
            ['name' => 'lokasi', 'label' => 'Lokasi', 'type' => 'text', 'is_required' => true, 'sort_order' => 20],
            ['name' => 'alamat', 'label' => 'Alamat Lengkap', 'type' => 'textarea', 'is_required' => true, 'sort_order' => 30],
            ['name' => 'bandwidth', 'label' => 'Bandwidth yang Dibutuhkan', 'type' => 'text', 'placeholder' => 'Contoh: 50 Mbps', 'is_required' => true, 'sort_order' => 40],
            ['name' => 'jenis_koneksi', 'label' => 'Jenis Koneksi', 'type' => 'select', 'options' => ['Fiber Optic', 'Wireless', 'VPN', 'Lainnya'], 'is_required' => true, 'sort_order' => 50],
            ['name' => 'alasan_permintaan', 'label' => 'Alasan Permintaan', 'type' => 'textarea', 'is_required' => true, 'sort_order' => 60],
            ['name' => 'surat_permohonan', 'label' => 'Surat Permohonan', 'type' => 'file', 'is_required' => true, 'validation_rules' => ['mimes:pdf', 'max:4096'], 'sort_order' => 70],
        ]);

        $this->seedRequirements($internet, [
            ['name' => 'Surat permohonan resmi', 'description' => 'Memuat lokasi dan kebutuhan akses internet.', 'allowed_file_types' => ['pdf'], 'max_file_size' => 4096, 'sort_order' => 10],
            ['name' => 'Foto lokasi', 'description' => 'Foto titik pemasangan bila tersedia.', 'is_required' => false, 'allowed_file_types' => ['jpg', 'jpeg', 'png'], 'max_file_size' => 2048, 'sort_order' => 20],
        ]);

        $this->seedFields($hosting, [
            ['name' => 'nama_aplikasi', 'label' => 'Nama Website/Aplikasi', 'type' => 'text', 'is_required' => true, 'sort_order' => 10],
            ['name' => 'domain', 'label' => 'Domain/Subdomain', 'type' => 'text', 'is_required' => true, 'sort_order' => 20],
            ['name' => 'platform', 'label' => 'Platform', 'type' => 'select', 'options' => ['Laravel', 'WordPress', 'Static Site', 'Lainnya'], 'is_required' => true, 'sort_order' => 30],
            ['name' => 'kebutuhan_storage', 'label' => 'Kebutuhan Storage', 'type' => 'text', 'placeholder' => 'Contoh: 10 GB', 'is_required' => true, 'sort_order' => 40],
            ['name' => 'kebutuhan_database', 'label' => 'Kebutuhan Database', 'type' => 'radio', 'options' => ['PostgreSQL', 'MySQL/MariaDB', 'Tidak Perlu'], 'is_required' => true, 'sort_order' => 50],
            ['name' => 'catatan_teknis', 'label' => 'Catatan Teknis', 'type' => 'textarea', 'is_required' => false, 'sort_order' => 60],
        ]);

        $this->seedRequirements($hosting, [
            ['name' => 'Dokumen permohonan hosting', 'description' => 'Surat atau nota dinas pengajuan hosting.', 'allowed_file_types' => ['pdf'], 'max_file_size' => 4096, 'sort_order' => 10],
        ]);
    }

    private function seedFields(Service $service, array $fields): void
    {
        foreach ($fields as $field) {
            $service->fields()->updateOrCreate(
                ['name' => $field['name']],
                [
                    'label' => $field['label'],
                    'type' => $field['type'],
                    'placeholder' => $field['placeholder'] ?? null,
                    'description' => $field['description'] ?? null,
                    'is_required' => $field['is_required'] ?? false,
                    'validation_rules' => $field['validation_rules'] ?? null,
                    'options' => $field['options'] ?? null,
                    'sort_order' => $field['sort_order'] ?? 0,
                    'is_active' => $field['is_active'] ?? true,
                ]
            );
        }
    }

    private function seedRequirements(Service $service, array $requirements): void
    {
        foreach ($requirements as $requirement) {
            $service->requirements()->updateOrCreate(
                ['name' => $requirement['name']],
                [
                    'description' => $requirement['description'] ?? null,
                    'is_required' => $requirement['is_required'] ?? true,
                    'allowed_file_types' => $requirement['allowed_file_types'] ?? null,
                    'max_file_size' => $requirement['max_file_size'] ?? null,
                    'sort_order' => $requirement['sort_order'] ?? 0,
                ]
            );
        }
    }
}
