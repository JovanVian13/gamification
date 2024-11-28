<?php
namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\UserVoucher;
use App\Models\VoucherRedemption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    // Show available vouchers and redemption history
    public function showVouchers()
    {
        $user = Auth::user();
        $userPoints = $user->points; // assuming the points are stored in the users table
        $vouchers = Voucher::all(); // Get all available vouchers
        $redemptions = VoucherRedemption::where('user_id', $user->id)->get(); // Get user's redemption history

        return view('user.redeem-vouchers', compact('vouchers', 'userPoints', 'redemptions'));
    }

    // Redeem a voucher
    public function redeemVoucher($voucherId)
    {
        $user = Auth::user(); // Ambil pengguna yang sedang login
        $voucher = Voucher::findOrFail($voucherId); // Ambil voucher berdasarkan ID
    
        // Periksa apakah poin pengguna mencukupi
        if ($user->points < $voucher->points_required) {
            return redirect()->back()->with('error', 'Poin tidak cukup untuk menukarkan voucher ini.');
        }
    
        // Periksa apakah voucher sudah pernah ditukarkan oleh pengguna
        if ($user->user_vouchers()->where('voucher_id', $voucherId)->exists()) {
            return redirect()->back()->with('error', 'Anda sudah menukarkan voucher ini sebelumnya.');
        }
    
        // Kurangi poin pengguna
        $user->points -= $voucher->points_required;
        $user->save();
    
        // Tambahkan catatan penukaran ke tabel pivot
        $user->vouchers()->attach($voucher->id, [
            'status' => 'redeemed', // Status default
            'created_at' => now(), // Timestamp otomatis
            'updated_at' => now(),
        ]);
    
        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Voucher berhasil ditukarkan!');
    }
    
}
