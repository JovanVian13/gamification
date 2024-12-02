<?php
namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportExport implements FromCollection
{
    public function collection()
    {
        return User::select('name', 'email', 'created_at')->get();
    }
}
