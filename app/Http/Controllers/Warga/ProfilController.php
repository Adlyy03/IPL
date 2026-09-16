<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfilController extends Controller
{
    /**
     * Tampilkan halaman profil warga.
     */
    public function show(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();
        $warga = $user->warga?->load('blok.gang');

        return view('warga.profil.show', compact('user', 'warga'));
    }

    /**
     * Perbarui data profil warga sendiri.
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();
        $warga = $user->warga;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'nomor_hp' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'nomor_hp.max' => 'Nomor HP maksimal 20 karakter.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // Update User
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        // Sync data Warga jika ada relasi
        if ($warga) {
            $warga->update([
                'nama_lengkap' => $validated['name'],
                'nomor_hp' => $validated['nomor_hp'] ?? null,
            ]);
        }

        return redirect()->route('warga.profil.show')->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
