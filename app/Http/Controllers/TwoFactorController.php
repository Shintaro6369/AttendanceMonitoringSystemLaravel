<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TwoFactorController extends Controller
{
    // Show the 2FA input form
    public function showVerify()
    {
        if (!session()->has('2fa_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.2fa-verify');
    }

    // Handle the code verification submission
    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'numeric'],
        ]);

        if ($request->code == session('2fa_code')) {
            $userId = session('2fa_user_id');
            $remember = session('remember_me', false);

            $user = User::findOrFail($userId);
            
            // Log the user in with their remember preference
            Auth::login($user, $remember);

            // Clear 2FA session data
            session()->forget(['2fa_user_id', '2fa_code', 'remember_me']);
            $request->session()->regenerate();

            // Redirect based on user role
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/search-student');
            }
            return redirect()->intended('/student/dashboard');
        }

        return back()->withErrors(['code' => 'The 2FA code entered is invalid. Please try again.']);
    }
}