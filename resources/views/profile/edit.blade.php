@extends('layouts.app')

@section('content')
<div class="glass-panel max-w-xl w-full p-8 rounded-3xl shadow-2xl border border-teal-500/30">
    <h2 class="text-2xl font-extrabold text-white mb-6">Account Profile</h2>

    @if(session('success'))
        <div class="mb-6 p-4 bg-teal-500/20 border border-teal-500/30 text-teal-200 text-xs rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-500/20 border border-red-500/30 text-red-200 text-xs rounded-xl">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Profile Header Preview -->
    <div class="flex items-center space-x-4 mb-8 p-4 bg-slate-900/50 rounded-2xl border border-teal-500/20">
        <img src="{{ asset('storage/profile_pictures/' . (Auth::user()->profile_picture ?? 'default-emo.jpg')) }}" 
             onerror="this.src='{{ asset('storage/profile_pictures/default-emo.jpg') }}'"
             class="w-16 h-16 rounded-full object-cover border-2 border-teal-400">
        <div>
            <h3 class="font-bold text-white text-lg">{{ Auth::user()->name }}</h3>
            <p class="text-xs text-teal-300 capitalize">Role: {{ Auth::user()->role }}</p>
            @if(Auth::user()->student_number)
                <p class="text-xs text-slate-400">Student No: {{ Auth::user()->student_number }}</p>
            @endif
        </div>
    </div>

    <!-- Profile Update Form -->
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Full Name</label>
            <input type="text" name="name" value="{{ Auth::user()->name }}" required class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white focus:outline-none focus:border-teal-400">
        </div>

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Change Profile Picture</label>
            <input type="file" name="profile_picture" class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white text-xs file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-teal-500 file:text-slate-950 hover:file:bg-teal-400">
        </div>

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">New Password (leave blank to keep current)</label>
            <input type="password" name="password" class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white focus:outline-none focus:border-teal-400">
        </div>

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white focus:outline-none focus:border-teal-400">
        </div>

        <div class="flex items-center justify-between pt-4">
            <a href="{{ Auth::user()->role === 'admin' ? route('admin.students.search') : route('student.dashboard') }}" class="text-xs text-teal-300 hover:underline">← Back to Dashboard</a>
            <button type="submit" class="py-3 px-6 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-400 hover:to-cyan-400 text-slate-950 font-bold rounded-xl shadow-lg shadow-teal-500/20 transition-all">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection