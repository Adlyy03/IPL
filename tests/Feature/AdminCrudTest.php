<?php

namespace Tests\Feature;

use App\Models\Blok;
use App\Models\Gang;
use App\Models\IuranWarga;
use App\Models\JenisIuran;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $userWarga;

    private Warga $warga;

    private Gang $gang;

    private Blok $blok;

    private JenisIuran $jenisIuran;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->gang = Gang::factory()->create([
            'nama_gang' => 'Gang Flamboyan',
            'status' => 'aktif',
        ]);

        $this->blok = Blok::factory()->create([
            'gang_id' => $this->gang->id,
            'nama_blok' => 'Blok B',
            'nomor_rumah' => '10',
            'status' => 'aktif',
        ]);

        $this->warga = Warga::factory()->create([
            'blok_id' => $this->blok->id,
            'nama_lengkap' => 'Warga Percobaan',
            'nik' => '3201123456789012',
            'nomor_hp' => '081234567890',
            'peran_keluarga' => 'kepala_keluarga',
            'status_warga' => 'tetap',
            'is_aktif' => true,
        ]);

        $this->userWarga = User::factory()->create([
            'role' => 'warga',
            'warga_id' => $this->warga->id,
        ]);

        $this->jenisIuran = JenisIuran::factory()->create([
            'nama_iuran' => 'Iuran Keamanan',
            'nominal' => 45000,
            'is_aktif' => true,
        ]);
    }

    // ==========================================
    // 1. CRUD GANG
    // ==========================================

    public function test_admin_bisa_melihat_daftar_gang(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.gang.index'));

        $response->assertStatus(200);
        $response->assertSee('Gang Flamboyan');
    }

    public function test_admin_bisa_menambah_gang_baru(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.gang.store'), [
            'nama_gang' => 'Gang Melati Indah',
            'keterangan' => 'Dekat pos satpam',
            'status' => 'aktif',
        ]);

        $response->assertRedirect(route('admin.gang.index'));
        $this->assertDatabaseHas('gangs', ['nama_gang' => 'Gang Melati Indah']);
    }

    public function test_admin_bisa_melihat_detail_gang(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.gang.show', $this->gang));

        $response->assertStatus(200);
        $response->assertSee($this->gang->nama_gang);
    }

    public function test_admin_bisa_mengupdate_gang(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.gang.update', $this->gang), [
            'nama_gang' => 'Gang Flamboyan Utama',
            'keterangan' => 'Keterangan diperbarui',
            'status' => 'aktif',
        ]);

        $response->assertRedirect(route('admin.gang.index'));
        $this->assertDatabaseHas('gangs', ['nama_gang' => 'Gang Flamboyan Utama']);
    }

    public function test_gang_tidak_dapat_dihapus_jika_memiliki_blok(): void
    {
        $response = $this->actingAs($this->admin)->delete(route('admin.gang.destroy', $this->gang));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('gangs', ['id' => $this->gang->id]);
    }

    public function test_gang_tanpa_blok_dapat_dihapus(): void
    {
        $gangKosong = Gang::factory()->create([
            'nama_gang' => 'Gang Kosong',
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.gang.destroy', $gangKosong));

        $response->assertRedirect(route('admin.gang.index'));
        $this->assertDatabaseMissing('gangs', ['id' => $gangKosong->id]);
    }

    // ==========================================
    // 2. CRUD BLOK & RUMAH
    // ==========================================

    public function test_admin_bisa_melihat_daftar_blok(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.blok.index'));

        $response->assertStatus(200);
        $response->assertSee('Blok B');
        $response->assertSee('No. 10');
    }

    public function test_admin_bisa_menambah_blok_baru(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.blok.store'), [
            'gang_id' => $this->gang->id,
            'nama_blok' => 'Blok C',
            'nomor_rumah' => '12',
            'keterangan' => 'Rumah baru',
            'status' => 'aktif',
        ]);

        $response->assertRedirect(route('admin.blok.index'));
        $this->assertDatabaseHas('bloks', [
            'nama_blok' => 'Blok C',
            'nomor_rumah' => '12',
        ]);
    }

    public function test_admin_bisa_melihat_detail_blok(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.blok.show', $this->blok));

        $response->assertStatus(200);
        $response->assertSee($this->blok->nama_blok);
        $response->assertSee($this->warga->nama_lengkap);
    }

    public function test_admin_bisa_mengupdate_blok(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.blok.update', $this->blok), [
            'gang_id' => $this->gang->id,
            'nama_blok' => 'Blok B Renovasi',
            'nomor_rumah' => '10',
            'keterangan' => 'Cat hijau',
            'status' => 'aktif',
        ]);

        $response->assertRedirect(route('admin.blok.index'));
        $this->assertDatabaseHas('bloks', ['nama_blok' => 'Blok B Renovasi']);
    }

    public function test_blok_tidak_dapat_dihapus_jika_memiliki_warga(): void
    {
        $response = $this->actingAs($this->admin)->delete(route('admin.blok.destroy', $this->blok));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('bloks', ['id' => $this->blok->id]);
    }

    // ==========================================
    // 3. CRUD WARGA
    // ==========================================

    public function test_admin_bisa_melihat_daftar_warga(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.warga.index'));

        $response->assertStatus(200);
        $response->assertSee('Warga Percobaan');
    }

    public function test_admin_bisa_menambah_warga_baru(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.warga.store'), [
            'blok_id' => $this->blok->id,
            'nama_lengkap' => 'Warga Baru Ditambah',
            'nik' => '3201999988887777',
            'nomor_hp' => '089876543210',
            'peran_keluarga' => 'kepala_keluarga',
            'status_warga' => 'tetap',
            'is_aktif' => true,
        ]);

        $response->assertRedirect(route('admin.warga.index'));
        $this->assertDatabaseHas('wargas', ['nama_lengkap' => 'Warga Baru Ditambah']);
    }

    public function test_admin_bisa_melihat_detail_warga(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.warga.show', $this->warga));

        $response->assertStatus(200);
        $response->assertSee($this->warga->nama_lengkap);
    }

    public function test_admin_bisa_mengupdate_warga(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.warga.update', $this->warga), [
            'blok_id' => $this->blok->id,
            'nama_lengkap' => 'Warga Percobaan Edit',
            'nik' => '3201123456789012',
            'nomor_hp' => '081234567899',
            'peran_keluarga' => 'kepala_keluarga',
            'status_warga' => 'tetap',
            'is_aktif' => true,
        ]);

        $response->assertRedirect(route('admin.warga.index'));
        $this->assertDatabaseHas('wargas', ['nama_lengkap' => 'Warga Percobaan Edit']);
    }

    // ==========================================
    // 4. CRUD JENIS IURAN
    // ==========================================

    public function test_admin_bisa_melihat_daftar_jenis_iuran(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.jenis-iuran.index'));

        $response->assertStatus(200);
        $response->assertSee('Iuran Keamanan');
    }

    public function test_admin_bisa_menambah_jenis_iuran_baru(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.jenis-iuran.store'), [
            'nama_iuran' => 'Iuran Sampah RT',
            'nominal' => 30000,
            'deskripsi' => 'Pengangkutan sampah 3x seminggu',
            'is_aktif' => true,
        ]);

        $response->assertRedirect(route('admin.jenis-iuran.index'));
        $this->assertDatabaseHas('jenis_iurans', ['nama_iuran' => 'Iuran Sampah RT']);
    }

    public function test_admin_bisa_melihat_detail_jenis_iuran(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.jenis-iuran.show', $this->jenisIuran));

        $response->assertStatus(200);
        $response->assertSee($this->jenisIuran->nama_iuran);
    }

    public function test_admin_bisa_mengupdate_jenis_iuran(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.jenis-iuran.update', $this->jenisIuran), [
            'nama_iuran' => 'Iuran Keamanan Malam',
            'nominal' => 50000,
            'deskripsi' => 'Gaji satpam',
            'is_aktif' => true,
        ]);

        $response->assertRedirect(route('admin.jenis-iuran.index'));
        $this->assertDatabaseHas('jenis_iurans', ['nama_iuran' => 'Iuran Keamanan Malam']);
    }

    // ==========================================
    // 5. TRANSAKSI & GENERATE IURAN WARGA
    // ==========================================

    public function test_admin_bisa_membuat_tagihan_manual(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.iuran-warga.store'), [
            'warga_id' => $this->warga->id,
            'jenis_iuran_id' => $this->jenisIuran->id,
            'periode' => '2026-09',
            'nominal' => 45000,
            'status_pembayaran' => 'menunggu_pembayaran',
            'catatan' => 'Tagihan manual September',
        ]);

        $response->assertRedirect(route('admin.iuran-warga.index'));
        $this->assertDatabaseHas('iuran_wargas', [
            'warga_id' => $this->warga->id,
            'periode' => '2026-09',
            'nominal' => 45000,
            'status_pembayaran' => 'menunggu_pembayaran',
        ]);
    }

    public function test_admin_bisa_generate_tagihan_massal_dengan_pencegahan_duplikasi(): void
    {
        // 1. Generate pertama
        $response1 = $this->actingAs($this->admin)->post(route('admin.iuran-warga.generate.store'), [
            'jenis_iuran_id' => $this->jenisIuran->id,
            'periode' => '2026-10',
            'nominal' => 45000,
            'cakupan' => 'semua',
            'hanya_kepala_keluarga' => true,
        ]);

        $response1->assertRedirect(route('admin.iuran-warga.index'));
        $this->assertDatabaseHas('iuran_wargas', [
            'warga_id' => $this->warga->id,
            'periode' => '2026-10',
        ]);

        $countAwal = IuranWarga::where('periode', '2026-10')->count();

        // 2. Generate kedua (periode & jenis sama) -> tidak boleh ada duplikat
        $response2 = $this->actingAs($this->admin)->post(route('admin.iuran-warga.generate.store'), [
            'jenis_iuran_id' => $this->jenisIuran->id,
            'periode' => '2026-10',
            'nominal' => 45000,
            'cakupan' => 'semua',
            'hanya_kepala_keluarga' => true,
        ]);

        $response2->assertRedirect(route('admin.iuran-warga.index'));
        $countAkhir = IuranWarga::where('periode', '2026-10')->count();

        $this->assertEquals($countAwal, $countAkhir);
    }

    public function test_admin_bisa_menandai_dan_membatalkan_pembayaran_iuran(): void
    {
        $iuran = IuranWarga::factory()->create([
            'warga_id' => $this->warga->id,
            'jenis_iuran_id' => $this->jenisIuran->id,
            'periode' => '2026-11',
            'nominal' => 45000,
            'status_pembayaran' => 'menunggu_pembayaran',
        ]);

        // Tandai bayar
        $responseBayar = $this->actingAs($this->admin)->post(route('admin.iuran-warga.bayar', $iuran));
        $responseBayar->assertSessionHas('success');
        $this->assertDatabaseHas('iuran_wargas', [
            'id' => $iuran->id,
            'status_pembayaran' => 'lunas',
        ]);

        // Batalkan bayar
        $responseBatal = $this->actingAs($this->admin)->post(route('admin.iuran-warga.batal-bayar', $iuran));
        $responseBatal->assertSessionHas('success');
        $this->assertDatabaseHas('iuran_wargas', [
            'id' => $iuran->id,
            'status_pembayaran' => 'menunggu_pembayaran',
        ]);
    }

    // ==========================================
    // 6. LAPORAN KEUANGAN IPL
    // ==========================================

    public function test_admin_bisa_melihat_laporan_keuangan_ipl(): void
    {
        IuranWarga::factory()->create([
            'warga_id' => $this->warga->id,
            'jenis_iuran_id' => $this->jenisIuran->id,
            'periode' => '2026-09',
            'nominal' => 45000,
            'status_pembayaran' => 'lunas',
            'tanggal_pembayaran' => now(),
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.laporan.index', [
            'periode' => '2026-09',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Laporan Penerimaan');
        $response->assertSee('Rp 45.000');
    }

    // ==========================================
    // 7. PORTAL WARGA & ISOLASI DATA
    // ==========================================

    public function test_warga_bisa_melihat_daftar_iuran_miliknya_sendiri(): void
    {
        IuranWarga::factory()->create([
            'warga_id' => $this->warga->id,
            'jenis_iuran_id' => $this->jenisIuran->id,
            'periode' => '2026-09',
            'nominal' => 45000,
            'status_pembayaran' => 'menunggu_pembayaran',
        ]);

        $response = $this->actingAs($this->userWarga)->get(route('warga.iuran.index'));

        $response->assertStatus(200);
        $response->assertSee('Riwayat');
        $response->assertSee('Iuran Keamanan');
        $response->assertSee('Rp 45.000');
    }

    public function test_warga_tidak_bisa_melihat_tagihan_warga_lain(): void
    {
        // Tagihan warga lain
        $wargaLain = Warga::factory()->create([
            'blok_id' => $this->blok->id,
            'nama_lengkap' => 'Warga Lain Tetangga',
        ]);

        IuranWarga::factory()->create([
            'warga_id' => $wargaLain->id,
            'jenis_iuran_id' => $this->jenisIuran->id,
            'periode' => '2026-09',
            'nominal' => 99000,
            'catatan' => 'Catatan Rahasia Tetangga 999',
        ]);

        $response = $this->actingAs($this->userWarga)->get(route('warga.iuran.index'));

        $response->assertStatus(200);
        $response->assertDontSee('Rp 99.000');
        $response->assertDontSee('Catatan Rahasia Tetangga 999');
    }

    public function test_warga_ditolak_mengakses_halaman_admin(): void
    {
        $response = $this->actingAs($this->userWarga)->get(route('admin.gang.index'));
        $response->assertStatus(403);

        $response2 = $this->actingAs($this->userWarga)->get(route('admin.iuran-warga.index'));
        $response2->assertStatus(403);
    }
}
