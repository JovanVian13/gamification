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
    // Show available vouchers and redemption history
    public function showVouchers()
    {
        $user = Auth::user();
        $userPoints = $user->points; 
        $vouchers = Voucher::all(); 
        $redemptions = VoucherRedemption::where('user_id', $user->id)->get(); 

        return view('user.redeem-vouchers', compact('vouchers', 'userPoints', 'redemptions'));
    }

    // Redeem a voucher
    public function redeemVoucher($voucherId)
    {
        $user = Auth::user(); // Ambil pengguna yang sedang login
        $voucher = Voucher::findOrFail($voucherId); 
    
        // Periksa apakah poin pengguna mencukupi
        if ($user->points < $voucher->points_required) {
            return redirect()->back()->with('error', 'Poin tidak cukup untuk menukarkan voucher ini.');
        }
    
        // Periksa apakah voucher sudah pernah ditukarkan oleh pengguna
        if ($user->vouchers()->where('voucher_id', $voucherId)->exists()) {
            return redirect()->back()->with('error', 'Anda sudah menukarkan voucher ini sebelumnya.');
        }
    
        // Kurangi poin pengguna
        $user->points -= $voucher->points_required;
        $user->save();

        $redeemedAt = now();
        $expired_date = $voucher->expired_date;

        // Buat notifikasi
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Voucher Redeemed',
            'message' => 'You have successfully redeemed the voucher: ' . $voucher->title,
            'read_status' => 'unread',
        ]);

    
        // Tambahkan catatan penukaran ke tabel pivot
        $user->vouchers()->attach($voucher->id, [
            'status' => 'redeemed', 
            'redeemed_at' => $redeemedAt,
            'created_at' => now(),
            'updated_at' => now(),
            'expired_date' => $expired_date,
        ]);
    
        // Catat transaksi di tabel VoucherRedemption
        VoucherRedemption::create([
            'user_id' => $user->id,
            'voucher_id' => $voucher->id,
            'points_used' => $voucher->points_required, 
            'status' => 'redeemed',
        ]);

        UserActivityHelper::log(
            $user->id,
            'point_conversion',
            $voucher->title,
            -$voucher->points_required
        );
    
        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Voucher berhasil ditukarkan!');
    }

    
    
}

