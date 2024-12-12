<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Badge;

class BadgesController extends Controller
{
    public function manageBadges()
    {
        $badges = Badge::paginate(10);
        $users = User::all();
        return view('admin.badges', compact('badges', 'users'));
    }

    // Create a new badge
    public function createBadge()
    {
        // Ambil semua pengguna dari database
        $users = User::all();

        // Kirim data ke view
        return view('admin.badgescreate', compact('users'));
    }
    public function storeBadge(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'criteria' => 'required|string',
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('badges', 'public');

        Badge::create([
            'name' => $request->name,
            'criteria' => $request->criteria,
            'image' => $path,
        ]);

        return redirect()->route('admin.badge')->with('success', 'Badge created successfully.');
    }

    public function editBadge(Badge $badge)
    {
        return view('admin.badgesedit', compact('badge'));
    }

    public function updateBadge(Request $request, Badge $badge)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'criteria' => 'required|string',
            'image' => 'nullable|image|max:2048', // Image optional
        ]);

        // Update badge data
        $badge->name = $request->name;
        $badge->criteria = $request->criteria;

        // Update image if a new one is uploaded
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('badges', 'public');
            $badge->image = $path;
        }

        $badge->save();

        return redirect()->route('admin.badge')->with('success', 'Badge updated successfully.');
    }

    // Assign badge to a user
    public function assignBadge(Request $request, Badge $badge)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        if ($user->badges->contains($badge->id)) {
            return redirect()->route('admin.badge')
                            ->with('error', 'Badge already assigned to this user.');
        }

        $user->badges()->attach($badge->id, ['earned_at' => now()]);

        return redirect()->route('admin.badge')->with('success', 'Badge assigned to user successfully.');
    }
}

