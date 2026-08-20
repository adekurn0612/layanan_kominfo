<?php

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

Artisan::command('app:baseline-existing-database {--force}', function (): int {
    $legacyTables = [
        'users',
        'cache',
        'cache_locks',
        'jobs',
        'job_batches',
        'failed_jobs',
        'organizations',
        'roles',
        'permissions',
        'permission_role',
        'role_user',
        'service_categories',
        'services',
        'service_fields',
        'service_requirements',
        'tickets',
    ];

    if (! Schema::hasTable('users')) {
        $this->line('Database belum memiliki schema lama; baseline dilewati.');

        return Command::SUCCESS;
    }

    if (! Schema::hasTable('migrations')) {
        Schema::create('migrations', function (Blueprint $table): void {
            $table->id();
            $table->string('migration');
            $table->integer('batch');
        });
    }

    if (DB::table('migrations')->exists()) {
        $this->line('Migration history sudah berisi data; baseline dilewati.');

        return Command::SUCCESS;
    }

    $missingTables = collect($legacyTables)->reject(fn (string $table): bool => Schema::hasTable($table));

    if ($missingTables->isNotEmpty() && ! $this->option('force')) {
        $this->error('Schema lama belum lengkap: ' . $missingTables->implode(', '));
        $this->line('Gunakan --force hanya setelah memastikan database produksi memang berasal dari schema lama.');

        return Command::FAILURE;
    }

    $legacyMigrations = [
        '0001_01_01_000000_create_users_table',
        '0001_01_01_000001_create_cache_table',
        '0001_01_01_000002_create_jobs_table',
        '2026_08_09_000001_create_organizations_table',
        '2026_08_09_000002_create_roles_and_permissions_table',
        '2026_08_09_000003_create_services_master_tables',
        '2026_08_12_000004_create_tickets_table',
        '2026_08_13_000005_add_image_path_to_service_categories_table',
        '2026_08_20_000006_add_phone_to_users_table',
    ];

    DB::table('migrations')->insert(array_map(
        fn (string $migration): array => ['migration' => $migration, 'batch' => 1],
        $legacyMigrations
    ));

    $this->info('Migration history lama berhasil dibuat. Migration baru siap dijalankan.');

    return Command::SUCCESS;
});

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
