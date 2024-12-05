<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Badge;
use App\Models\Point;

class BadgesController extends Controller
{
    public function manageBadges()
    {
        $badges = Badge::all();
        $users = User::all(); // Fetch all users
        return view('admin.badges', compact('badges', 'users'));
    }

    // Create a new badge
    public function createBadge(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'criteria' => 'required|string',
            'image' => 'required|image|max:2048', // Max 2MB
        ]);

        $path = $request->file('image')->store('badges', 'public');

        Badge::create([
            'name' => $request->name,
            'criteria' => $request->criteria,
            'image' => $path,
        ]);

        return redirect()->route('admin.badge')->with('success', 'Badge created successfully.');
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

