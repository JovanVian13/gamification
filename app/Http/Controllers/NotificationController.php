<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function manageNotification()
    {
        // Fetch notifications for all users with user relationship
        $notifications = Notification::with('user')->latest()->get();
        return view('admin.notification', compact('notifications'));
    }

    public function createNotification()
    {
        // Pass users to view for recipient selection
        $users = User::all();
        return view('admin.notificationcreate', compact('users'));
    }

    public function storeNotification(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'required', // Can be "all" or a specific user ID
        ]);

        if ($request->user_id === 'all') {
            // Kirim ke semua pengguna
            $users = User::all();
            foreach ($users as $user) {
                Notification::create([
                    'user_id' => $user->id,
                    'title' => $request->title,
                    'message' => $request->message,
                    'read_status' => 'unread',
                ]);
            }
        } else {
            // Kirim ke satu pengguna
            Notification::create([
                'user_id' => $request->user_id,
                'title' => $request->title,
                'message' => $request->message,
                'read_status' => 'unread',
            ]);
        }

        return redirect()->route('admin.notification')->with('success', 'Notification created successfully.');
    }

    public function userNotifications()
    {
        $userId = auth()->id(); // Mendapatkan ID pengguna yang sedang login
        $notifications = Notification::where('user_id', $userId)
            ->latest()
            ->take(3)
            ->get();

        $allNotifications = Notification::where('user_id', $userId)->latest()->get();

        return view('user.notifications', compact('notifications', 'allNotifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['read_status' => 'read']);

        return redirect()->route('user.notifications')->with('success', 'Notification marked as read.');
    }

    public function deleteNotification($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->route('user.notifications')->with('success', 'Notification deleted successfully.');
    }

}
