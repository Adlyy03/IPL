<?php

namespace App\Notifications;

use App\Models\IuranWarga;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class IuranNotification extends Notification
{
    use Queueable;

    /**
     * @param  'tagihan_baru'|'pengingat_belum_bayar'|'pembayaran_sukses'  $type
     */
    public function __construct(
        public IuranWarga $iuranWarga,
        public string $type = 'tagihan_baru',
        public ?string $customMessage = null
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $namaIuran = $this->iuranWarga->jenisIuran?->nama_iuran ?? 'Iuran Lingkungan';
        $nominal = number_format($this->iuranWarga->nominal, 0, ',', '.');
        $periode = $this->iuranWarga->periode;

        $title = match ($this->type) {
            'pembayaran_sukses' => 'Pembayaran Iuran Dikonfirmasi',
            'pengingat_belum_bayar' => 'Pengingat Tagihan Belum Dibayar',
            default => 'Tagihan Iuran Baru Tersedia',
        };

        $message = $this->customMessage ?? match ($this->type) {
            'pembayaran_sukses' => "Pembayaran untuk {$namaIuran} periode {$periode} sebesar Rp {$nominal} telah tercatat lunas.",
            'pengingat_belum_bayar' => "Anda memiliki tagihan {$namaIuran} periode {$periode} sebesar Rp {$nominal} yang belum dibayar.",
            default => "Tagihan {$namaIuran} periode {$periode} sebesar Rp {$nominal} telah diterbitkan.",
        };

        return [
            'type' => $this->type,
            'title' => $title,
            'message' => $message,
            'iuran_warga_id' => $this->iuranWarga->id,
            'periode' => $periode,
            'nominal' => $this->iuranWarga->nominal,
            'url' => route('warga.iuran.index'),
        ];
    }
}
