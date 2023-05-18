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
            $table->unsignedBigInteger('unit_id')->after('id')->nullable();
            $table->foreign('unit_id')->references('id')->on('unit')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('indikator_mutu', function (Blueprint $table) {
            //rollback
            $table->dropForeign(['unit_id']);
            $table->dropColumn('unit_id');
        });
    }
};
