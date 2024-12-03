<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        // Ambil pengaturan dari database
        $settings = Setting::all()->pluck('value', 'key');

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->only([
            'task_point_rule',
            'point_to_voucher',
            'task_deadline',
            'leaderboard_reset_time',
            'email_template',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->route('admin.settings')->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
