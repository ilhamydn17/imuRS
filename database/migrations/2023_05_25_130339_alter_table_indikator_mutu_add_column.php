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
        Schema::table('indikator_mutu', function (Blueprint $table) {
            // tambah kolom status
            $table->integer('status')->default(0)->after('nama_denumerator');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('indikator_mutu', function (Blueprint $table) {
            //create rollback for this migration
            $table->dropColumn('status');
        });
    }
};
