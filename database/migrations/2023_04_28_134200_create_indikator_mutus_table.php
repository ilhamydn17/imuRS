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
        Schema::create('indikator_mutu', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('unit_id')->nullable()->unique();
            // $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->string('nama_indikator');
            $table->string('nama_numerator');
            $table->string('nama_denumerator');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indikator_mutus');
    }
};
