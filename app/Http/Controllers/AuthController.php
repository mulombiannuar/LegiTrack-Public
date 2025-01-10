<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\APIService;
use App\Services\AuthService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $apiService;
    protected $authService;

    public function __construct(APIService $apiService, AuthService $authService)
    {
        $this->apiService = $apiService;
        $this->authService = $authService;
    }
    public function showLoginForm(): View
    {
        return view('auth.login', [
            'title' => 'Login',
            'next' => request()->query('next', null)
        ]);
    }

    public function login(LoginUserRequest $request): RedirectResponse
    {
        $nextPage = $request->input('next', null);
        $requestData = $request->except(['_method', '_token', 'next']);
        $userData = $this->authService->login($requestData);

        if (empty($userData || !$userData['status'])) {
            return back()->with('warning', 'Invalid credentials. Please try again.');
        }

        // Use the extracted method to handle login
        $this->handleUserLogin($userData);

        return redirect($nextPage ?? route('home'))
            ->with('success', 'You have successfully logged in.');
    }

    public function showRegistrationForm(): View
    {
        return view('auth.register', [
            'title' => 'Register',
            'counties' => $this->apiService->getCounties(),
            'next' => request()->query('next', null),
        ]);
    }
    public function register(RegisterUserRequest $request): RedirectResponse
    {
        $appName = config('app.name');
        $nextPage = $request->input('next', null);
        $requestData = $request->except(['_method', '_token', 'next']);
        $userData = $this->authService->register($requestData);

        if (empty($userData || !$userData['status'])) {
            return back()->with('warning', "An error has occured while creating your $appName account. Please try again later");
        }

        // Use the extracted method to handle login
        $this->handleUserLogin($userData);

        return redirect($nextPage ?? route('home'))
            ->with('success', "You have successfully registered on the {$appName} portal. You can now submit your comments for reviews and feedback on various published bills.");
    }

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

    public function logout(Request $request): RedirectResponse
    {
        $userLoggedOut = $this->authService->logout();
        if (!$userLoggedOut) {
            return back()->with('warning', 'There was a problem while logging out your account. Please try again');
        }
        return back()->with('success', 'You are logged out successfully');
    }

    private function handleUserLogin(array $userData): void
    {
        // Extract the token and user data
        $token = $userData['data']['token'];
        $user = $userData['data']['user'];

        // Log the user into the current application using Sanctum
        Auth::loginUsingId($user['id'], true);

        // Store the token in session or cookie for further authenticated requests
        session(['api_token' => $token]);
    }
}
