<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;

class LogSuccessfulLogin
{
    public function __construct()
    {
        // No dependencies required for this listener
    }

    public function handle(Login $event)
    {
        // Update the last_login timestamp for the authenticated user
        $event->user->update(['last_login' => now()]);
    }
}
