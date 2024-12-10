<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserVoucher;
use Carbon\Carbon;

class ExpireVouchers extends Command
{
    protected $signature = 'vouchers:expire';
    protected $description = 'Mark expired vouchers as expired';

    public function handle()
    {
        UserVoucher::where('status', 'redeemed')
            ->where('expired_at', '<', now())
            ->update(['status' => 'expired']);

        $this->info('Expired vouchers updated successfully.');
    }
}
