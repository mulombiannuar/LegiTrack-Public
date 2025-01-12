<?php

declare(strict_types=1);

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mews\Purifier\Facades\Purifier;

//Get current logged in authenticated user
function user(): ?User
{
    return Auth::user();
}

//Get User id
function userId(): ?Int
{
    return Auth::id();
}

//Change date format to specified one
function change_date_format(string $date, string $date_format): string
{
    return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format($date_format);
}

// Format mobile number add 254 extension to it
function format_mobile_number($mobile_no): String
{
    // Trim any whitespace from the input
    $mobile_no = trim($mobile_no);

    // Check if the number starts with '01' or '07' and has a length of 10 digits
    if (preg_match('/^0[17]\d{8}$/', $mobile_no)) {
        // Remove the leading '0' and add '254'
        $mobile_no = '254' . substr($mobile_no, 1);
    }

    return $mobile_no;
}

//Get greetings
function get_greetings(string $username): String
{
    date_default_timezone_set("Africa/Nairobi");
    $greetings = '';
    $time = date("H");
    if ($time < "12") {
        $greetings = "Good morning " . ucwords($username);
    } elseif ($time >= "12" && $time < "15") {
        $greetings = "Good afternoon " . ucwords($username);
    } else {
        $greetings = "Good evening " . ucwords($username);
    }
    return $greetings;
}

// form date to January 1, 2023 format
if (!function_exists('format_date')) {
    function format_date($dateString, string $format = 'Y-m-d H:i:s')
    {
        $parsedDate = Carbon::parse($dateString);
        $formattedDate = $parsedDate->format($format);
        return $formattedDate;
    }
}

function split_permission($str): string
{
    $parts = explode(':', $str);
    return $parts[1] ?? ''; // account types:create returns create
}

function user_last_login(int $userId, string $event): string
{
    $loginHistory = DB::table('audits')->where(['user_id' => $userId, 'event' => $event])->latest()->first();
    return $loginHistory ? $loginHistory->created_at : '';
}
function categories(): iterable
{
    $categoryService = app('App\Services\Admin\CategoryService');
    return  $categoryService->getAllCategories(true);
}

function limitWords($string, $wordLimit = 7): string
{
    $words = explode(' ', $string);
    if (count($words) > $wordLimit) {
        return implode(' ', array_slice($words, 0, $wordLimit)) . '...';
    }
    return $string;
}

function maskEmail(string $email): string
{
    // Split the email into the username and domain part
    [$username, $domain] = explode('@', $email);

    // Get the first two characters and the last character of the username
    $firstTwo = substr($username, 0, 2);
    $lastChar = substr($username, -1);

    // Replace the middle part with asterisks
    $maskedUsername = $firstTwo . str_repeat('*', strlen($username) - 3) . $lastChar;

    // Return the formatted email
    return $maskedUsername . '@' . $domain;
}

function maskMobileNumber(string $mobile): string
{
    // Get the first 3 and last 2 characters of the mobile number
    $firstThree = substr($mobile, 0, 3);
    $lastTwo = substr($mobile, -2);

    // Replace the middle part with asterisks
    $maskedNumber = $firstThree . str_repeat('*', strlen($mobile) - 5) . $lastTwo;

    // Return the masked mobile number
    return $maskedNumber;
}

function bytesToKilobytes(int $bytes, int $precision = 2): float
{
    return round($bytes / 1024, $precision);
}

function getFontAwesomeIcon(string $fileType = 'fa fa-file'): string
{
    $iconMap = [
        'application/pdf' => 'fa fa-file-pdf',
        'application/msword' => 'fa fa-file-word',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'fa fa-file-word',
        'application/vnd.ms-excel' => 'fa fa-file-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'fa fa-file-excel',
        'application/vnd.ms-powerpoint' => 'fa fa-file-powerpoint',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'fa fa-file-powerpoint',
        'image/jpeg' => 'fa fa-file-image',
        'image/png' => 'fa fa-file-image',
        'image/gif' => 'fa fa-file-image',
        'text/plain' => 'fa fa-file-alt',
        'text/csv' => 'fa fa-file-csv',
        'application/zip' => 'fa fa-file-archive',
        'application/x-rar-compressed' => 'fa fa-file-archive',
        'video/mp4' => 'fa fa-file-video',
        'audio/mpeg' => 'fa fa-file-audio',
        // Add more MIME types as needed
    ];

    return $iconMap[$fileType] ?? 'fa fa-file';
}
