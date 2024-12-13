<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VoucherManage;
use Carbon\Carbon;

class UpdateVoucherStatus extends Command
{
    protected $signature = 'voucher:update-status';
    protected $description = 'Update the status of vouchers based on expiration date';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();

        $expiredVouchers = VoucherManage::where('expired_date', '<=', $now)
                                        ->where('status', 'active')
                                        ->update(['status' => 'expired']);

        $this->info("$expiredVouchers vouchers have been marked as expired.");
    }
}
