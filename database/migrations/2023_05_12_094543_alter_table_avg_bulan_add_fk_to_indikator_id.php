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
        Schema::table('avg_bulan', function (Blueprint $table) {
            $table->unsignedBigInteger('indikator_id')->after('id')->nullable();
            $table->foreign('indikator_id')->references('id')->on('indikator_mutu')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('avg_bulan', function (Blueprint $table) {
            // create rollback for this migration
            $table->dropForeign(['indikator_id']);
            $table->dropColumn('indikator_id');
        });
    }
};
