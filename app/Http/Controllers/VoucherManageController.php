<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VoucherManage;


class VoucherManageController extends Controller
{
    // 1. Menampilkan daftar voucher
    public function manageVoucher()
    {
        $vouchers = VoucherManage::orderBy('created_at', 'desc')->get();
        return view('admin.vouchermanage', compact('vouchers'));
    }

    // 2. Form untuk membuat voucher baru
    public function createVoucher()
    {
        return view('admin.vouchercreate');
    }

    // 3. Menyimpan voucher baru
    public function storeVoucher(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_required' => 'required|integer|min:1',
            'code' => 'required|string|max:255',
        ]);

        VoucherManage::create([
            'title' => $request->title,
            'description' => $request->description,
            'points_required' => $request->points_required,
            'code' => $request->code,
            'status' => 'active',
        ]);

        return redirect()->route('admin.voucher')->with('success', 'Voucher berhasil dibuat.');
    }

    // 4. Form untuk mengedit voucher
    public function editVoucher(VoucherManage $voucher)
    {
        return view('admin.voucheredit', compact('voucher'));
    }

    // 5. Memperbarui voucher
    public function updateVoucher(Request $request, VoucherManage $voucher)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_required' => 'required|integer|min:1',
            'status' => 'required|in:active,expired',
        ]);

        $voucher->update($request->all());

        return redirect()->route('admin.voucher')->with('success', 'Voucher berhasil diperbarui.');
    }

    // 6. Menghapus voucher
    public function deleteVoucher(VoucherManage $voucher)
    {
        $voucher->delete();
        return redirect()->route('admin.voucher')->with('success', 'Voucher berhasil dihapus.');
    }
}
