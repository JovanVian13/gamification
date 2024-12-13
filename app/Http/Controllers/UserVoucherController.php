<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\VoucherRedemption;
use Illuminate\Support\Facades\Auth;

class UserVoucherController extends Controller
{
    public function redeemVouchers()
    {
        $user = Auth::user();

        // Ambil semua voucher untuk katalog
        $vouchers = Voucher::all();

        // Ambil relasi user_vouchers dengan voucher untuk pengguna yang sedang login
        $userVouchers = $user->vouchers()->with('users')->get();


        // Hitung total poin pengguna
        $userPoints = $user->points;

        // Ambil riwayat penukaran dari tabel VoucherRedemption dengan relasi voucher
        $redemptions = VoucherRedemption::where('user_id', $user->id)->with('voucher')->get();

        // Sorting redemptions: 'redeemed' first, then 'expired'
        $redemptions = $redemptions->sortBy(function ($redemption) {
            $voucher = $redemption->voucher;
            if (!$voucher) {
                return [1, 1]; // Jika voucher tidak ditemukan, tempatkan di akhir
            }
            $isExpired = now()->greaterThan($voucher->expired_date);
            return [$isExpired ? 1 : 0, $redemption->status !== 'redeemed' ? 1 : 0];
        });

        return view('user.redeem-vouchers', compact('vouchers', 'userVouchers', 'userPoints', 'redemptions'));
    }
}
