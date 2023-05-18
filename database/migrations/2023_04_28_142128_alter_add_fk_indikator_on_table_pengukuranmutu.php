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
        Schema::table('pengukuran_mutu', function (Blueprint $table) {
            $table->unsignedBigInteger('indikator_mutu_id')->after('id')->nullable();
            $table->foreign('indikator_mutu_id')->references('id')->on('indikator_mutu')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengukuran_mutu', function (Blueprint $table) {
            //rollback
            $table->dropForeign(['indikator_mutu_id']);
            $table->dropColumn('indikator_mutu_id');
        });
    }
};
