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
        if (!Schema::hasTable('tahun_ajars') || Schema::hasColumn('tahun_ajars', 'is_active')) {
            return;
        }

        Schema::table('tahun_ajars', function (Blueprint $table) {
            $table->boolean('is_active')->default(false)->after('nama_tahun_ajar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('tahun_ajars') || !Schema::hasColumn('tahun_ajars', 'is_active')) {
            return;
        }

        Schema::table('tahun_ajars', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
