<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Voucher;
use Carbon\Carbon;

class UpdateVoucherStatus extends Command
{
    protected $signature = 'vouchers:update-status';
    protected $description = 'Update voucher status based on expiration date';

    public function handle()
    {
        $expiredVouchers = Voucher::where('expired_date', '<=', Carbon::now())->where('status', 'active')->update(['status' => 'expired']);
        $this->info("$expiredVouchers vouchers updated to expired.");
    }
}
