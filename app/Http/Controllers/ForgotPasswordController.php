<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();
        
        // Reset password back to default for easy student recovery
        $user->password = Hash::make('defaultpassword123');
        $user->save();

        return back()->with('status', 'Password has been reset to default: defaultpassword123. You can now log in.');
    }
}