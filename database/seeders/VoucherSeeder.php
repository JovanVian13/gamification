<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VoucherSeeder extends Seeder
{
    public function run()
    {
        DB::table('vouchers')->insert([
            [
                'title' => 'Discount 10%',
                'description' => 'Get a 10% discount on your next purchase.',
                'points_required' => 100,
                'code' => Str::upper(Str::random(8)),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Free Shipping',
                'description' => 'Enjoy free shipping on orders above $50.',
                'points_required' => 200,
                'code' => Str::upper(Str::random(8)),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Buy 1 Get 1 Free',
                'description' => 'Buy one item and get another one for free.',
                'points_required' => 300,
                'code' => Str::upper(Str::random(8)),
                'status' => 'expired',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
