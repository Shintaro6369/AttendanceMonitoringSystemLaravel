<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AttendanceLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    // Show student search page for admin with latest time-in log
    public function search(Request $request)
    {
        $student = null;
        $latestLog = null;

        if ($request->has('student_number') && $request->student_number != '') {
            $student = User::where('student_number', $request->student_number)
                           ->where('role', 'student')
                           ->first();

            // Fetch the student's latest attendance/time-in log if found
            if ($student) {
                $latestLog = AttendanceLog::where('user_id', $student->id)
                                          ->latest()
                                          ->first();
            }
        }

        return view('admin.search-student', compact('student', 'latestLog'));
    }

    // Show student registration form for admin
    public function create()
    {
        return view('admin.register-student');
    }

    // Store new student with custom image renaming and a unique random password
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'student_number' => 'required|unique:users,student_number',
            'course' => 'required|string',
            'year_section' => 'required|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Generate a unique random temporary password for this specific student
        $plainPassword = 'St-' . rand(100000, 999999);

        // Default if no image is uploaded
        $newFileName = 'default-emo.jpg';

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $extension = $file->getClientOriginalExtension();
            // Custom naming format requested: student_number-SR-0.ext
            $newFileName = $request->student_number . '-SR-0.' . $extension;
            
            // Explicitly store in public disk under profile_pictures folder
            $file->storeAs('profile_pictures', $newFileName, 'public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->student_number . '@student.edu', // Auto-generated login email
            'password' => Hash::make($plainPassword),
            'temp_password' => $plainPassword, // Stored so admin can view it on search
            'role' => 'student',
            'student_number' => $request->student_number,
            'course' => $request->course,
            'year_section' => $request->year_section,
            'profile_picture' => $newFileName
        ]);

        return back()->with('success', 'Student account created successfully! Generated Password: ' . $plainPassword);
    }

    // Show student edit form (Admin)
    public function edit($id)
    {
        $student = User::where('role', 'student')->findOrFail($id);
        return view('admin.edit-student', compact('student'));
    }

    // Update student details and profile picture (Admin)
    public function update(Request $request, $id)
    {
        $student = User::where('role', 'student')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'student_number' => 'required|unique:users,student_number,' . $student->id,
            'course' => 'required|string',
            'year_section' => 'required|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $student->name = $request->name;
        $student->student_number = $request->student_number;
        $student->email = $request->student_number . '@student.edu';
        $student->course = $request->course;
        $student->year_section = $request->year_section;

        // Handle profile picture update if a new file is uploaded
        if ($request->hasFile('profile_picture')) {
            if ($student->profile_picture && $student->profile_picture !== 'default-emo.jpg') {
                Storage::disk('public')->delete('profile_pictures/' . $student->profile_picture);
            }
            $file = $request->file('profile_picture');
            $extension = $file->getClientOriginalExtension();
            $filename = $request->student_number . '-SR-0.' . $extension;
            $file->storeAs('profile_pictures', $filename, 'public');
            $student->profile_picture = $filename;
        }

        $student->save();

        return redirect()->route('admin.students.search', ['student_number' => $student->student_number])
                         ->with('success', 'Student account updated successfully!');
    }

    // Delete student account (Admin)
    public function destroy($id)
    {
        $student = User::findOrFail($id);
        
        // Delete profile picture from storage if it exists and isn't the default fallback
        if ($student->profile_picture && $student->profile_picture !== 'default-emo.jpg') {
            Storage::disk('public')->delete('profile_pictures/' . $student->profile_picture);
        }

        $student->delete();

        return redirect()->route('admin.students.search')->with('success', 'Student account deleted.');
    }

    // Student Dashboard View
    public function studentDashboard()
    {
        $logs = AttendanceLog::where('user_id', Auth::id())->latest()->get();
        return view('student.dashboard', compact('logs'));
    }

    // Student Time-In Action
    public function timeIn(Request $request)
    {
        AttendanceLog::create([
            'user_id' => Auth::id(),
            'time_in' => now(),
        ]);

        return back()->with('success', 'Time-in recorded successfully!');
    }
}