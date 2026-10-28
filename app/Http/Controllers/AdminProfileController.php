<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    public function edit()
    {
        $admin = Auth::user();
        return view('admin.profile-edit', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|min:6|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            if ($admin->profile_picture && $admin->profile_picture !== 'default-emo.jpg') {
                Storage::disk('public')->delete('profile_pictures/' . $admin->profile_picture);
            }
            $file = $request->file('profile_picture');
            $filename = 'admin-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('profile_pictures', $filename, 'public');
            $admin->profile_picture = $filename;
        }

        $admin->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}