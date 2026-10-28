<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    // Step 1: Show form to enter email address
    public function showEmailForm()
    {
        return view('auth.forgot-password');
    }

    // Step 2: Verify email exists in database
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'We could not find an account with that email address.'
        ]);

        $user = User::where('email', $request->email)->first();

        // Store user ID temporarily in session for the password reset step
        session(['reset_user_id' => $user->id]);

        return redirect()->route('password.reset.form');
    }

    // Step 3: Show new password form
    public function showResetForm()
    {
        if (!session()->has('reset_user_id')) {
            return redirect()->route('password.request');
        }
        return view('auth.reset-password');
    }

    // Step 4: Save the new password
    public function updatePassword(Request $request)
    {
        if (!session()->has('reset_user_id')) {
            return redirect()->route('password.request');
        }

        $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::findOrFail(session('reset_user_id'));
        $user->password = Hash::make($request->password);
        $user->temp_password = $request->password; // Update temp password viewable by admin if needed
        $user->save();

        // Clear session token
        session()->forget('reset_user_id');

        return redirect()->route('login')->with('success', 'Password successfully updated! You can now log in with your new password.');
    }
}