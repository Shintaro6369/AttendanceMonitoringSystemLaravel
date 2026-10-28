@extends('layouts.app')

@section('content')
<div class="glass-panel max-w-xl w-full p-8 rounded-3xl shadow-2xl border border-teal-500/30">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-extrabold text-white">Edit Student Account</h2>
        <a href="{{ route('admin.students.search', ['student_number' => $student->student_number]) }}" class="text-xs text-teal-300 hover:underline">← Cancel</a>
    </div>

    <form action="{{ route('admin.students.update', $student->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Full Name</label>
            <input type="text" name="name" value="{{ old('name', $student->name) }}" required class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white text-xs focus:outline-none focus:border-teal-400">
        </div>

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Student Number</label>
            <input type="text" name="student_number" value="{{ old('student_number', $student->student_number) }}" required class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white text-xs focus:outline-none focus:border-teal-400">
        </div>

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Course</label>
            <input type="text" name="course" value="{{ old('course', $student->course) }}" required class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white text-xs focus:outline-none focus:border-teal-400">
        </div>

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Year & Section</label>
            <input type="text" name="year_section" value="{{ old('year_section', $student->year_section) }}" required class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white text-xs focus:outline-none focus:border-teal-400">
        </div>

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Update Profile Picture (Optional)</label>
            <input type="file" name="profile_picture" class="w-full text-xs text-teal-200 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-500/20 file:text-teal-300 hover:file:bg-teal-500/30">
        </div>

        <button type="submit" class="w-full py-3 bg-gradient-to-r from-teal-500 to-cyan-500 text-slate-950 font-bold rounded-xl text-xs transition">
            Save Changes
        </button>
    </form>
</div>
@endsection