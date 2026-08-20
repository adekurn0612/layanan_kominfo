<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ticket_follow_ups', function (Blueprint $table) {
            $table->boolean('is_public')->default(false)->after('comment')->index();
        });
    }

    public function down(): void
    {
        Schema::table('ticket_follow_ups', function (Blueprint $table) {
            $table->dropColumn('is_public');
        });
    }
};
