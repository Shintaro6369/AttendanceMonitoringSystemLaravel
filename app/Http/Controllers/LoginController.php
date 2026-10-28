<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    // Show the login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle login submission with "Remember Me" and 2FA trigger
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Validate credentials without logging in yet
        if (Auth::validate($credentials)) {
            $user = User::where('email', $request->email)->first();

            // Temporarily store user ID and remember preference in session for 2FA verification
            session([
                '2fa_user_id' => $user->id,
                'remember_me' => $request->has('remember')
            ]);

            // Generate a 6-digit 2FA code (For testing convenience, we flash it to session/info)
            $code = rand(100000, 999999);
            session(['2fa_code' => $code]);

            // Redirect to 2FA verification screen
            return redirect()->route('2fa.verify')->with('info', 'Your 2FA Verification Code is: ' . $code);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Handle logout
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}