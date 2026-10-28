@extends('layouts.app')

@section('content')
<div class="glass-panel max-w-md w-full p-8 rounded-3xl shadow-2xl border border-teal-500/30">
    <h2 class="text-2xl font-extrabold text-white mb-2">Reset Password</h2>
    <p class="text-xs text-teal-200/80 mb-6">Enter your school email address to reset your password to default.</p>

    @if (session('status'))
        <div class="mb-4 p-3 bg-teal-500/20 border border-teal-500/30 text-teal-200 text-xs rounded-xl">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Email Address</label>
            <input type="email" name="email" required class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white text-xs focus:outline-none focus:border-teal-400">
        </div>

        <button type="submit" class="w-full py-3 bg-gradient-to-r from-teal-500 to-cyan-500 text-slate-950 font-bold rounded-xl text-xs transition">
            Reset Password
        </button>

        <div class="text-center pt-2">
            <a href="{{ route('login') }}" class="text-xs text-teal-300 hover:underline">← Back to Login</a>
        </div>
    </form>
</div>
@endsection