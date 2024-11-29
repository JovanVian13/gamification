<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserVoucherController extends Controller
{
    // Method untuk menampilkan halaman Riwayat Penukaran Voucher
    public function redeemVouchers()
    {
        // Ambil data user_vouchers milik pengguna yang sedang login
        $userVouchers = auth()->user()->userVouchers()->with('voucher')->get();

        // Kirim data ke view
        return view('user.redeem-vouchers', compact('userVouchers'));
    }
}
