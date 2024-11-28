<?php
namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\Redemption;
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
        $redemptions = Redemption::where('user_id', $user->id)->get(); // Get user's redemption history

        return view('user.redeem-vouchers', compact('vouchers', 'userPoints', 'redemptions'));
    }

    // Redeem a voucher
    public function redeemVoucher($voucherId)
    {
        $user = Auth::user();
        $voucher = Voucher::findOrFail($voucherId);

        if ($user->points >= $voucher->points_required) {
            // Deduct points from user
            $user->points -= $voucher->points_required;
            $user->save();

            // Create redemption record
            Redemption::create([
                'user_id' => $user->id,
                'voucher_id' => $voucher->id,
                'status' => 'Aktif', // Mark as active, you can implement expiration logic later
            ]);

            return redirect()->route('voucher.redeem')->with('success', 'Voucher berhasil ditukarkan!');
        }

        return redirect()->route('voucher.redeem')->with('error', 'Poin tidak cukup untuk menukarkan voucher ini.');
    }
}
