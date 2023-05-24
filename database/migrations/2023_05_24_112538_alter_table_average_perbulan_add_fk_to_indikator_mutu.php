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
        Schema::table('average_perbulan', function (Blueprint $table) {
            //add foreign key to indikator_mutu
            $table->unsignedBigInteger('indikator_mutu_id')->after('id')->nullable();
            $table->foreign('indikator_mutu_id')->references('id')->on('indikator_mutu')->nullable()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('average_perbulan', function (Blueprint $table) {
            //create rollback for this migration
            $table->dropForeign(['indikator_mutu_id']);
            $table->dropColumn('indikator_mutu_id');
        });
    }
};
