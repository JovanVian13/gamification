<?php
namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\VoucherRedemption;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\UserActivityHelper;

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
        $user = Auth::user();
        $voucher = Voucher::findOrFail($voucherId);

        if ($user->points < $voucher->points_required) {
            return redirect()->back()->with('error', 'Poin tidak cukup untuk menukarkan voucher ini.');
        }

        if ($user->vouchers()->where('voucher_id', $voucherId)->exists()) {
            return redirect()->back()->with('error', 'Anda sudah menukarkan voucher ini sebelumnya.');
        }

        $user->points -= $voucher->points_required;
        $user->save();

        $redeemedAt = now();
        $expiredAt = (clone $redeemedAt)->addDays(7);

        $user->vouchers()->attach($voucher->id, [
            'status' => 'redeemed',
            'redeemed_at' => $redeemedAt,
            'expired_at' => $expiredAt,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        // Catat transaksi di tabel VoucherRedemption
        VoucherRedemption::create([
            'user_id' => $user->id,
            'voucher_id' => $voucher->id,
            'points_used' => $voucher->points_required, 
            'status' => 'redeemed',  // Status penukaran voucher
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

