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
            'user_id' => 'required|exists:users,id', // Validate recipient user
        ]);

        Notification::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'message' => $request->message,
            'read_status' => 'unread',
        ]);

        return redirect()->route('admin.notification')->with('success', 'Notification created successfully.');
    }
}
