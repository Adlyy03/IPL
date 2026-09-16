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
        Schema::create('iuran_wargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->constrained('wargas')->restrictOnDelete();
            $table->foreignId('jenis_iuran_id')->constrained('jenis_iurans')->restrictOnDelete();
            $table->string('periode', 7); // Format: YYYY-MM (e.g. 2026-09)
            $table->decimal('nominal', 12, 2);
            $table->enum('status_pembayaran', ['menunggu_pembayaran', 'lunas', 'batal'])->default('menunggu_pembayaran');
            $table->timestamp('tanggal_pembayaran')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->index(['warga_id', 'periode']);
            $table->index(['periode', 'status_pembayaran']);
            $table->index('status_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iuran_wargas');
    }
};
