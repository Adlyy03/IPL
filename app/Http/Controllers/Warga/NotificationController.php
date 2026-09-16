<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Tandai notifikasi spesifik sebagai sudah dibaca (hanya milik user login).
     */
    public function markAsRead(Request $request, string $id): RedirectResponse
    {
        $notification = $request->user()
            ->notifications()
            ->findOrFail($id);

        $notification->markAsRead();

        $targetUrl = $notification->data['url'] ?? route('warga.iuran.index');

        return redirect($targetUrl);
    }

    /**
     * Tandai semua notifikasi pengguna sebagai telah dibaca.
     */
    public function markAllAsRead(Request $request): RedirectResponse
    {
        $request->user()
            ->unreadNotifications
            ->markAsRead();

        return back()->with('success', 'Semua notifikasi telah ditandai sudah dibaca.');
    }
}
