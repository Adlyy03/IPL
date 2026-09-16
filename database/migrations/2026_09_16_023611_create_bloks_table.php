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
        Schema::create('bloks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gang_id')->constrained('gangs')->restrictOnDelete();
            $table->string('nama_blok', 50);
            $table->string('nomor_rumah', 20);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['gang_id', 'nama_blok', 'nomor_rumah']);
            $table->index('nama_blok');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bloks');
    }
};
