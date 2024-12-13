<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Models\VoucherRedemption;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Helpers\UserActivityHelper;

class VoucherController extends Controller
{
    // Menampilkan voucher dan riwayat penukaran
    public function showVouchers()
    {
        $user = Auth::user();
        $userPoints = $user->points;

        // Ambil semua voucher
        $vouchers = Voucher::all();

        // Ambil riwayat penukaran voucher
        $redemptions = VoucherRedemption::where('user_id', $user->id)->with('voucher')->get();

        // Sorting redemptions: 'redeemed' first, then 'expired'
        $redemptions = $redemptions->sortBy(function ($redemption) {
            $isExpired = now()->greaterThan($redemption->voucher->expired_date);
            return [$isExpired ? 1 : 0, $redemption->status !== 'redeemed' ? 1 : 0];
        });

        return view('user.redeem-vouchers', compact('vouchers', 'userPoints', 'redemptions'));
    }

    // Menukarkan voucher
    public function redeemVoucher($voucherId)
    {
        $user = Auth::user();
        $voucher = Voucher::findOrFail($voucherId);

        // Periksa apakah poin pengguna mencukupi
        if ($user->points < $voucher->points_required) {
            return redirect()->back()->with('error', 'Poin tidak cukup untuk menukarkan voucher ini.');
        }

        // Periksa apakah voucher sudah pernah ditukarkan oleh pengguna
        if (VoucherRedemption::where('user_id', $user->id)->where('voucher_id', $voucherId)->exists()) {
            return redirect()->back()->with('error', 'Anda sudah menukarkan voucher ini sebelumnya.');
        }

        // Kurangi poin pengguna
        $user->points -= $voucher->points_required;
        $user->save();

        // Buat catatan penukaran
        VoucherRedemption::create([
            'user_id' => $user->id,
            'voucher_id' => $voucherId,
            'points_used' => $voucher->points_required,
        ]);

        // Buat notifikasi
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Voucher Redeemed',
            'message' => 'Anda berhasil menukarkan voucher: ' . $voucher->title,
            'read_status' => 'unread',
        ]);

        // Catat aktivitas pengguna
        UserActivityHelper::log(
            $user->id,
            'point_conversion',
            $voucher->title,
            -$voucher->points_required
        );

        return redirect()->back()->with('success', 'Voucher berhasil ditukarkan!');
    }
}
