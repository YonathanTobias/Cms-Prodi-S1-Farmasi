<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->string('type', 50)->default('dosen')->after('position'); // 'dosen' atau 'tendik'
            $table->string('expertise', 255)->nullable()->after('type'); // Bidang Kepakaran / Keahlian
            $table->string('academic_rank', 100)->nullable()->after('expertise'); // Jabatan Fungsional
            $table->boolean('is_active')->default(true)->after('order_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropColumn(['type', 'expertise', 'academic_rank', 'is_active']);
        });
    }
};
