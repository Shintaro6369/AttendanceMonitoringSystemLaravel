@extends('layouts.app')

@section('content')
<div class="glass-panel max-w-md w-full p-8 rounded-3xl shadow-2xl border border-teal-500/30">
    <h2 class="text-2xl font-extrabold text-white mb-2">Create New Password</h2>
    <p class="text-xs text-teal-200/80 mb-6">Please enter your new secure password below.</p>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-500/20 border border-red-500/30 text-red-200 text-xs rounded-xl">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">New Password</label>
            <input type="password" name="password" placeholder="Enter new password (min. 6 chars)" required autofocus class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white text-xs focus:outline-none focus:border-teal-400">
        </div>

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Confirm New Password</label>
            <input type="password" name="password_confirmation" placeholder="Confirm new password" required class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white text-xs focus:outline-none focus:border-teal-400">
        </div>

        <button type="submit" class="w-full py-3 bg-gradient-to-r from-teal-500 to-cyan-500 text-slate-950 font-bold rounded-xl text-xs transition">
            Update Password
        </button>
    </form>
</div>
@endsection