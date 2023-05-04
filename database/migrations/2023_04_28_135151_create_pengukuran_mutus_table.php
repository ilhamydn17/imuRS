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
        Schema::create('pengukuran_mutu', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('indikator_mutu_id')->nullable()->unique();
            // $table->foreign('indikator_mutu_id')->references('id')->on('indikator_mutu')->onDelete('cascade');
            $table->decimal('numerator');
            $table->decimal('denumerator');
            $table->decimal('prosentase');
            $table->date('tanggal_input');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengukuran_mutus');
    }
};
