<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserVoucherSeeder extends Seeder
{
    public function run()
    {
        DB::table('user_vouchers')->insert([
            [
                'user_id' => 1,
                'voucher_id' => 1,
                'status' => 'redeemed',
                'redeemed_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'voucher_id' => 2,
                'status' => 'pending',
                'redeemed_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
