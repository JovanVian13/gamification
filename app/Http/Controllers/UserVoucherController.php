<?php

namespace App\Http\Controllers;
use App\Models\Voucher;

class UserVoucherController extends Controller
{
    // Method untuk menampilkan halaman Riwayat Penukaran Voucher
    public function redeemVouchers()
    {
        // Ambil semua voucher untuk katalog
        $vouchers = Voucher::all();
    
        // Ambil user_vouchers berdasarkan pengguna yang sedang login
        $userVouchers = auth()->user()->userVouchers()->with('voucher')->get();
    
        // Hitung total poin pengguna (misalnya disimpan di tabel users)
        $userPoints = auth()->user()->points()->sum('points');
    
        // Kirimkan data ke view
        return view('user.redeem-vouchers', compact('vouchers', 'userVouchers', 'userPoints'));
    }
}
