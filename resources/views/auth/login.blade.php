@extends('layouts.app')

@section('content')
<div class="glass-panel max-w-md w-full p-8 rounded-3xl shadow-2xl border border-teal-500/30">
    <h2 class="text-2xl font-extrabold text-white mb-6">Login to Portal</h2>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-500/20 border border-red-500/30 text-red-200 text-xs rounded-xl">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white text-xs focus:outline-none focus:border-teal-400">
        </div>

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Password</label>
            <input type="password" name="password" required class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white text-xs focus:outline-none focus:border-teal-400">
        </div>

        <!-- Remember Me & Forgot Password Row -->
        <div class="flex items-center justify-between text-xs">
            <label class="flex items-center text-teal-300 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded bg-slate-900 border-teal-500/30 text-teal-500 focus:ring-teal-400 mr-2">
                Remember Me
            </label>

            <!-- LINKING THE FORGOT PASSWORD ROUTE HERE -->
            <a href="{{ route('password.request') }}" class="text-teal-300 hover:underline">Forgot Password?</a>
        </div>

        <button type="submit" class="w-full py-3 bg-gradient-to-r from-teal-500 to-cyan-500 text-slate-950 font-bold rounded-xl text-xs transition">
            Login
        </button>
    </form>
</div>
@endsection