<?php

namespace Tests\Feature;

use App\Models\Blok;
use App\Models\Gang;
use App\Models\IuranWarga;
use App\Models\JenisIuran;
use App\Models\User;
use App\Models\Warga;
use App\Notifications\IuranNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class WargaFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected User $wargaUser1;

    protected Warga $warga1;

    protected User $wargaUser2;

    protected Warga $warga2;

    protected User $adminUser;

    protected JenisIuran $jenisIuran;

    protected function setUp(): void
    {
        parent::setUp();

        $gang = Gang::create(['nama_gang' => 'Gang Melati']);
        $blok1 = Blok::create(['gang_id' => $gang->id, 'nama_blok' => 'Blok A', 'nomor_rumah' => '01']);
        $blok2 = Blok::create(['gang_id' => $gang->id, 'nama_blok' => 'Blok B', 'nomor_rumah' => '02']);

        $this->warga1 = Warga::create([
            'blok_id' => $blok1->id,
            'nama_lengkap' => 'Budi Santoso',
            'nik' => '3201010101010001',
            'nomor_hp' => '081234567890',
            'status_warga' => 'tetap',
            'peran_keluarga' => 'kepala_keluarga',
            'is_aktif' => true,
        ]);

        $this->wargaUser1 = User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'budi@ipl.test',
            'password' => Hash::make('password'),
            'role' => 'warga',
            'warga_id' => $this->warga1->id,
        ]);

        $this->warga2 = Warga::create([
            'blok_id' => $blok2->id,
            'nama_lengkap' => 'Siti Aminah',
            'nik' => '3201010101010002',
            'nomor_hp' => '081234567899',
            'status_warga' => 'tetap',
            'peran_keluarga' => 'kepala_keluarga',
            'is_aktif' => true,
        ]);

        $this->wargaUser2 = User::factory()->create([
            'name' => 'Siti Aminah',
            'email' => 'siti@ipl.test',
            'password' => Hash::make('password'),
            'role' => 'warga',
            'warga_id' => $this->warga2->id,
        ]);

        $this->adminUser = User::factory()->create([
            'name' => 'Pengurus Admin',
            'email' => 'admin@ipl.test',
            'role' => 'admin',
        ]);

        $this->jenisIuran = JenisIuran::create([
            'nama_iuran' => 'Iuran Kebersihan',
            'nominal' => 30000,
            'is_aktif' => true,
        ]);
    }

    public function test_warga_melihat_dashboard_dengan_banner_belum_bayar(): void
    {
        IuranWarga::create([
            'warga_id' => $this->warga1->id,
            'jenis_iuran_id' => $this->jenisIuran->id,
            'periode' => now()->format('Y-m'),
            'nominal' => 30000,
            'status_pembayaran' => 'menunggu_pembayaran',
        ]);

        $response = $this->actingAs($this->wargaUser1)->get(route('warga.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Peringatan Kewajiban Iuran');
        $response->assertSee('30.000');
        $response->assertSee('Lihat dan Bayar Tagihan');
    }

    public function test_warga_bisa_melihat_rincian_tagihan_milik_sendiri(): void
    {
        $iuran = IuranWarga::create([
            'warga_id' => $this->warga1->id,
            'jenis_iuran_id' => $this->jenisIuran->id,
            'periode' => '2026-09',
            'nominal' => 30000,
            'status_pembayaran' => 'menunggu_pembayaran',
        ]);

        $response = $this->actingAs($this->wargaUser1)->get(route('warga.iuran.show', $iuran->id));

        $response->assertStatus(200);
        $response->assertSee('Rincian Tagihan Iuran');
        $response->assertSee('Budi Santoso');
        $response->assertSee('30.000');
        $response->assertSee('MENUNGGU PEMBAYARAN');
    }

    public function test_warga_dilarang_melihat_rincian_tagihan_milik_warga_lain(): void
    {
        $iuranWargaLain = IuranWarga::create([
            'warga_id' => $this->warga2->id,
            'jenis_iuran_id' => $this->jenisIuran->id,
            'periode' => '2026-09',
            'nominal' => 50000,
            'status_pembayaran' => 'menunggu_pembayaran',
        ]);

        // Warga 1 mencoba mengakses tagihan Warga 2 -> Ditolak 403 Forbidden
        $response = $this->actingAs($this->wargaUser1)->get(route('warga.iuran.show', $iuranWargaLain->id));

        $response->assertStatus(403);
    }

    public function test_warga_bisa_melihat_halaman_profil(): void
    {
        $response = $this->actingAs($this->wargaUser1)->get(route('warga.profil.show'));

        $response->assertStatus(200);
        $response->assertSee('Profil Saya & Pengaturan Akun');
        $response->assertSee('Budi Santoso');
        $response->assertSee('Blok A No. 01');
    }

    public function test_warga_bisa_memperbarui_profil_dan_sinkron_ke_data_warga(): void
    {
        $response = $this->actingAs($this->wargaUser1)->put(route('warga.profil.update'), [
            'name' => 'Budi Santoso Baru',
            'email' => 'budi_baru@ipl.test',
            'nomor_hp' => '08999999999',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect(route('warga.profil.show'));
        $response->assertSessionHas('success');

        // Pastikan nama dan email terupdate di tabel users
        $this->assertDatabaseHas('users', [
            'id' => $this->wargaUser1->id,
            'name' => 'Budi Santoso Baru',
            'email' => 'budi_baru@ipl.test',
        ]);

        // Pastikan nama_lengkap dan nomor_hp tersinkron ke tabel wargas
        $this->assertDatabaseHas('wargas', [
            'id' => $this->warga1->id,
            'nama_lengkap' => 'Budi Santoso Baru',
            'nomor_hp' => '08999999999',
        ]);

        // Pastikan password baru bisa digunakan untuk login
        $this->assertTrue(Hash::check('newpassword123', $this->wargaUser1->fresh()->password));
    }

    public function test_warga_bisa_menandai_notifikasi_sebagai_dibaca(): void
    {
        $iuran = IuranWarga::create([
            'warga_id' => $this->warga1->id,
            'jenis_iuran_id' => $this->jenisIuran->id,
            'periode' => '2026-09',
            'nominal' => 30000,
            'status_pembayaran' => 'menunggu_pembayaran',
        ]);

        $this->wargaUser1->notify(new IuranNotification($iuran, 'tagihan_baru'));
        $this->assertEquals(1, $this->wargaUser1->unreadNotifications->count());

        $notificationId = $this->wargaUser1->unreadNotifications->first()->id;

        $response = $this->actingAs($this->wargaUser1)->post(route('warga.notifikasi.baca', $notificationId));

        $response->assertRedirect(route('warga.iuran.index'));
        $this->assertEquals(0, $this->wargaUser1->fresh()->unreadNotifications->count());
    }

    public function test_warga_bisa_menandai_semua_notifikasi_sebagai_dibaca(): void
    {
        $iuran = IuranWarga::create([
            'warga_id' => $this->warga1->id,
            'jenis_iuran_id' => $this->jenisIuran->id,
            'periode' => '2026-09',
            'nominal' => 30000,
            'status_pembayaran' => 'menunggu_pembayaran',
        ]);

        $this->wargaUser1->notify(new IuranNotification($iuran, 'tagihan_baru'));
        $this->wargaUser1->notify(new IuranNotification($iuran, 'pengingat_belum_bayar'));
        $this->assertEquals(2, $this->wargaUser1->unreadNotifications->count());

        $response = $this->actingAs($this->wargaUser1)->post(route('warga.notifikasi.baca-semua'));

        $response->assertRedirect();
        $this->assertEquals(0, $this->wargaUser1->fresh()->unreadNotifications->count());
    }

    public function test_admin_bisa_ekspor_laporan_excel(): void
    {
        IuranWarga::create([
            'warga_id' => $this->warga1->id,
            'jenis_iuran_id' => $this->jenisIuran->id,
            'periode' => '2026-09',
            'nominal' => 30000,
            'status_pembayaran' => 'lunas',
        ]);

        $response = $this->actingAs($this->adminUser)->get(route('admin.laporan.export-excel', [
            'periode' => '2026-09',
        ]));

        $response->assertStatus(200);
        $this->assertTrue(
            str_contains($response->headers->get('content-disposition') ?? '', '.xlsx'),
            'Header Content-Disposition tidak berisi ekstensi .xlsx'
        );
    }

    public function test_admin_bisa_ekspor_laporan_pdf(): void
    {
        IuranWarga::create([
            'warga_id' => $this->warga1->id,
            'jenis_iuran_id' => $this->jenisIuran->id,
            'periode' => '2026-09',
            'nominal' => 30000,
            'status_pembayaran' => 'lunas',
        ]);

        $response = $this->actingAs($this->adminUser)->get(route('admin.laporan.export-pdf', [
            'periode' => '2026-09',
        ]));

        $response->assertStatus(200);
        $this->assertTrue(
            str_contains($response->headers->get('content-disposition') ?? '', '.pdf') ||
            $response->headers->get('content-type') === 'application/pdf',
            'Header response bukan format PDF'
        );
    }
}
