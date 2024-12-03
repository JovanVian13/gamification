<?php

namespace App\Http\Controllers;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Example data
        $data = ['key' => 'admin value']; // Replace with actual admin data

        // Return the view and pass data
        return view('admin.dashboard', compact('data'));
    }
}
