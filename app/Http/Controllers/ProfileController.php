<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Show profile edit page
    public function edit()
    {
        return view('profile.edit');
    }

    // Update profile details, password, and picture
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user->name = $request->name;

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $extension = $file->getClientOriginalExtension();
            
            // Name format: student_number or user id prefix + extension
            $fileName = ($user->student_number ?? 'admin_' . $user->id) . '-profile.' . $extension;
            $file->storeAs('public/profile_pictures', $fileName);
            
            $user->profile_picture = $fileName;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}