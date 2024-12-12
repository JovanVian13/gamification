<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\ActivityLog;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Mengecek apakah email ada di database
        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user) {
            // Jika ada, cek apakah passwordnya benar
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $role = Auth::user()->role;
                
                // Log activity
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'action' => 'User logged in',
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                ]);

                // Redirect berdasarkan role user
                if ($role === 'user') {
                    return redirect()->route('user.dashboard');
                } else {
                    return redirect()->route('admin.dashboard');
                }
            } else {
                // Password salah
                return back()->withErrors(['password' => 'Password salah.']);
            }
        } else {
            // Email tidak ditemukan
            return back()->withErrors(['email' => 'Email tidak terdaftar.']);
        }
    }


    public function logout(Request $request)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'User logged out',
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);
        Auth::logout();
        return redirect()->route('login');
    }

    // Menampilkan form forgot password
    public function showForgot()
    {
        return view('auth.forgot-password');
    }

    // Mengirim link reset password ke email pengguna
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    // Menampilkan form reset password
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // Memproses reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|confirmed',
            'token' => 'required',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->password = Hash::make($request->password);
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Password has been reset!');
        }

        return back()->withErrors(['email' => [__($status)]]);
    }
}
