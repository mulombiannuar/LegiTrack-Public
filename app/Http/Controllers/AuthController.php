<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login', ['title' => 'Login']);
    }

    public function login(Request $request) {}

    public function showRegistrationForm(): View
    {
        return view('auth.register', ['title' => 'Register']);
    }
    public function register(Request $request) {}

    public function showForgotPasswordForm(): View
    {
        return view('auth.forgot_password', ['title' => 'Forgot Password']);
    }

    public function sendResetLinkEmail(Request $request) {}

    public function showResetPasswordForm(): View
    {
        return view('auth.reset_password', ['title' => 'Reset Password']);
    }

    public function resetPassword(Request $request) {}

    public function logout(Request $request) {}
}
