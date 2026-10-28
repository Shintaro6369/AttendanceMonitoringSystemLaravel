@extends('layouts.app')

@section('content')
<div class="glass-panel max-w-xl w-full p-8 rounded-3xl shadow-2xl border border-teal-500/30">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-extrabold text-white">Edit Admin Profile</h2>
        <a href="{{ route('admin.students.search') }}" class="text-xs text-teal-300 hover:underline">← Back to Search Portal</a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-teal-500/20 border border-teal-500/30 text-teal-200 text-xs rounded-xl">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name', $admin->name) }}" required class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white text-xs focus:outline-none focus:border-teal-400">
        </div>

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Email Address</label>
            <input type="email" name="email" value="{{ old('email', $admin->email) }}" required class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white text-xs focus:outline-none focus:border-teal-400">
        </div>

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">New Password (Optional)</label>
            <input type="password" name="password" class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white text-xs focus:outline-none focus:border-teal-400">
        </div>

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white text-xs focus:outline-none focus:border-teal-400">
        </div>

        <button type="submit" class="w-full py-3 bg-gradient-to-r from-teal-500 to-cyan-500 text-slate-950 font-bold rounded-xl text-xs transition">
            Update Profile
        </button>
    </form>
</div>
@endsection