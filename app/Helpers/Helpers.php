<?php

declare(strict_types=1);

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

// Currently authenticated user
function user(): ?User
{
    return Auth::user();
}

// Currently authenticated user's id
function userId(): ?int
{
    return Auth::id();
}

// Format a date string, e.g. format_date($date, 'F j, Y') gives "January 1, 2023"
if (! function_exists('format_date')) {
    function format_date($dateString, string $format = 'Y-m-d H:i:s'): string
    {
        return Carbon::parse($dateString)->format($format);
    }
}
