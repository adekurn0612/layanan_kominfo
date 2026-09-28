<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->timestamp('target_deadline_at')->nullable()->after('submitted_at')->index();
            $table->timestamp('first_response_at')->nullable()->after('target_deadline_at')->index();
            $table->timestamp('resolved_at')->nullable()->after('first_response_at')->index();
            $table->timestamp('closed_at')->nullable()->after('resolved_at')->index();

            $table->string('sla_status')->default('pending')->after('closed_at')->index();
            $table->boolean('sla_breached')->default(false)->after('sla_status')->index();
            $table->string('priority')->default('medium')->after('sla_breached')->index();
            $table->decimal('response_hours', 8, 2)->nullable()->after('priority');
            $table->decimal('resolution_hours', 8, 2)->nullable()->after('response_hours');
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropIndex(['target_deadline_at']);
            $table->dropIndex(['first_response_at']);
            $table->dropIndex(['resolved_at']);
            $table->dropIndex(['closed_at']);
            $table->dropIndex(['sla_status']);
            $table->dropIndex(['sla_breached']);
            $table->dropIndex(['priority']);

            $table->dropColumn([
                'target_deadline_at',
                'first_response_at',
                'resolved_at',
                'closed_at',
                'sla_status',
                'sla_breached',
                'priority',
                'response_hours',
                'resolution_hours',
            ]);
        });
    }
};
