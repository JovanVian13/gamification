<?php

namespace App\Helpers;

use App\Models\UserActivity;

class UserActivityHelper
{
    public static function log($userId, $type, $detail = null, $points = null)
    {
        UserActivity::create([
            'user_id' => $userId,
            'activity_type' => $type,
            'activity_detail' => $detail,
            'points_earned' => $points,
        ]);
    }
}
