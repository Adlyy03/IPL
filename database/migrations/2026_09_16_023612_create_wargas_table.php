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
        Schema::create('wargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blok_id')->constrained('bloks')->restrictOnDelete();
            $table->string('nama_lengkap', 150);
            $table->string('nik', 16)->nullable()->unique();
            $table->string('nomor_hp', 20)->nullable();
            $table->enum('peran_keluarga', ['kepala_keluarga', 'istri', 'anak', 'lainnya'])->default('kepala_keluarga');
            $table->enum('status_warga', ['tetap', 'kontrak', 'kost'])->default('tetap');
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();

            $table->index('nama_lengkap');
            $table->index('nomor_hp');
            $table->index('is_aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wargas');
    }
};
