<?php

namespace Tests\Feature;

use App\Models\Blok;
use App\Models\Gang;
use App\Models\IuranWarga;
use App\Models\JenisIuran;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthAndRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_login_dapat_diakses_tamu(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Masuk ke Sistem IPL');
    }

    public function test_tamu_diarahkan_ke_login_saat_akses_halaman_utama(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_login_gagal_dengan_kredensial_salah(): void
    {
        User::factory()->create([
            'email' => 'pengguna@ipl.test',
            'password' => Hash::make('password_benar'),
            'role' => 'warga',
        ]);

        $response = $this->post('/login', [
            'email' => 'pengguna@ipl.test',
            'password' => 'password_salah',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_admin_bisa_login_dan_diarahkan_ke_dashboard_admin(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@ipl.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@ipl.test',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_warga_bisa_login_dan_diarahkan_ke_dashboard_warga(): void
    {
        $warga = User::factory()->create([
            'email' => 'warga@ipl.test',
            'password' => Hash::make('password'),
            'role' => 'warga',
        ]);

        $response = $this->post('/login', [
            'email' => 'warga@ipl.test',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('warga.dashboard'));
        $this->assertAuthenticatedAs($warga);
    }

    public function test_warga_dilarang_mengakses_halaman_admin(): void
    {
        $warga = User::factory()->create([
            'role' => 'warga',
        ]);

        $response = $this->actingAs($warga)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    public function test_admin_tidak_dibatasi_mengakses_halaman_warga(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/warga/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Portal Mandiri Warga');
    }

    public function test_tamu_diarahkan_ke_login_saat_akses_halaman_terproteksi(): void
    {
        $responseAdmin = $this->get('/admin/dashboard');
        $responseAdmin->assertRedirect(route('login'));

        $responseWarga = $this->get('/warga/dashboard');
        $responseWarga->assertRedirect(route('login'));
    }

    public function test_pengguna_bisa_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_dashboard_admin_menampilkan_data_ringkasan_dan_tabel(): void
    {
        $gang = Gang::create(['nama_gang' => 'Gang Melati']);
        $blok = Blok::create(['gang_id' => $gang->id, 'nama_blok' => 'Blok A', 'nomor_rumah' => '01']);
        $warga = Warga::create(['blok_id' => $blok->id, 'nama_lengkap' => 'Budi Santoso', 'nik' => '3201010101010001']);
        $jenisIuran = JenisIuran::create(['nama_iuran' => 'Iuran Kebersihan', 'nominal' => 25000]);
        IuranWarga::create([
            'warga_id' => $warga->id,
            'jenis_iuran_id' => $jenisIuran->id,
            'periode' => now()->format('Y-m'),
            'nominal' => 25000,
            'status_pembayaran' => 'lunas',
            'tanggal_pembayaran' => now(),
        ]);

        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Dashboard Administrator');
        $response->assertSee('Gang Melati');
        $response->assertSee('Budi Santoso');
        $response->assertSee('Iuran Kebersihan');
        $response->assertSee('Ringkasan Pembayaran');
    }

    public function test_dashboard_warga_hanya_menampilkan_data_miliknya_sendiri(): void
    {
        $gang = Gang::create(['nama_gang' => 'Gang Melati']);
        $blok = Blok::create(['gang_id' => $gang->id, 'nama_blok' => 'Blok A', 'nomor_rumah' => '01']);
        $warga1 = Warga::create(['blok_id' => $blok->id, 'nama_lengkap' => 'Budi Santoso', 'nik' => '3201010101010001']);
        $warga2 = Warga::create(['blok_id' => $blok->id, 'nama_lengkap' => 'Warga Lain', 'nik' => '3201010101010002']);

        $jenisIuran = JenisIuran::create(['nama_iuran' => 'Iuran Keamanan', 'nominal' => 35000]);

        // Iuran untuk Warga 1 (Budi Santoso)
        IuranWarga::create([
            'warga_id' => $warga1->id,
            'jenis_iuran_id' => $jenisIuran->id,
            'periode' => now()->format('Y-m'),
            'nominal' => 35000,
            'status_pembayaran' => 'menunggu_pembayaran',
        ]);

        // Iuran untuk Warga 2 (Warga Lain)
        IuranWarga::create([
            'warga_id' => $warga2->id,
            'jenis_iuran_id' => $jenisIuran->id,
            'periode' => now()->format('Y-m'),
            'nominal' => 99000,
            'status_pembayaran' => 'lunas',
        ]);

        $userWarga1 = User::factory()->create([
            'name' => $warga1->nama_lengkap,
            'role' => 'warga',
            'warga_id' => $warga1->id,
        ]);

        $response = $this->actingAs($userWarga1)->get('/warga/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Budi Santoso');
        $response->assertSee('Blok A No. 01');
        $response->assertSee('35.000');
        // Pastikan tidak menampilkan iuran warga lain
        $response->assertDontSee('99.000');
        $response->assertDontSee('Warga Lain');
    }
}
