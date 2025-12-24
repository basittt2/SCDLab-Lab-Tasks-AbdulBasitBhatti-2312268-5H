<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class AuthController extends Controller
{
    // Registration Form
    public function showLinkRequestForm() {
         // Placeholder if needed
    }
    
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle Registration
    public function register(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password Hashing
        ]);

        // Send Verification Logic
        // Laravel's MustVerifyEmail handles this if we fire the event or if we call sendEmailVerificationNotification()
        // Assuming 'event(new Registered($user));' or manual call.
        // We will call manual notification.
        $user->sendEmailVerificationNotification();

        Auth::login($user); // Optional: Login immediately? Requirements say "After registration, send link". 
        // Usually, you might login but restrict access, or redirect to a "verify your email" page.
        // I will logout and redirect to login with message.
        Auth::logout();

        return redirect()->route('login')->with('success', 'Registration successful! Please check your email to verify your account.');
    }

    // Login Form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Check Verification
            if (!Auth::user()->hasVerifiedEmail()) {
                Auth::logout();
                return back()->withErrors(['email' => 'Your email address is not verified.']);
            }

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Verification Logic for link click
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403);
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            // event(new Verified($user)); // Requires import of Verified event if we want to fire it
        }

        return redirect('/login')->with('success', 'Email Verified! You can now login.');
    }

    // Resend Verification
    public function resendVerification(Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    }

    // Dashboard
    public function dashboard()
    {
        return view('dashboard');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
