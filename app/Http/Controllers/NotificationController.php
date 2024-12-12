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
        $notifications = Notification::with('user')->latest()->paginate(10);
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
            'user_id' => 'required',
        ]);

        if ($request->user_id === 'all') {
            $notifications = User::pluck('id')->map(function ($userId) use ($request) {
                return [
                    'user_id' => $userId,
                    'title' => $request->title,
                    'message' => $request->message,
                    'read_status' => 'unread',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            });
            Notification::insert($notifications->toArray());
        } else {
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
        $userId = auth()->id();
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

    public function editNotification($id)
    {
        $notification = Notification::findOrFail($id);
        $users = User::all();
        return view('admin.notificationedit', compact('notification', 'users'));
    }

    public function updateNotification(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'required',
        ]);

        $notification = Notification::findOrFail($id);
        $notification->update([
            'title' => $request->title,
            'message' => $request->message,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('admin.notification')->with('success', 'Notification updated successfully.');
    }

    public function deleteNotificationAdmin($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        return redirect()->route('admin.notification')->with('success', 'Notification deleted successfully.');
    }

}
