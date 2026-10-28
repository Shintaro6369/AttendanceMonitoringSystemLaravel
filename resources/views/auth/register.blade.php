@extends('layouts.app')

@section('content')
<div class="glass-panel max-w-md w-full p-8 rounded-3xl shadow-2xl border border-teal-500/30">
    <h2 class="text-2xl font-extrabold text-white mb-6 text-center">Admin Registration</h2>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-500/20 border border-red-500/30 text-red-200 text-xs rounded-xl">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="registerForm" method="POST" action="{{ route('register.submit') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white focus:outline-none focus:border-teal-400">
        </div>

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Password</label>
            <input type="password" id="password" name="password" required class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white focus:outline-none focus:border-teal-400">
            <p id="strengthIndicator" class="text-xs mt-1 text-red-400 font-semibold">Password Strength: Weak</p>
        </div>

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white focus:outline-none focus:border-teal-400">
            <p id="matchIndicator" class="text-xs mt-1 text-slate-400">Passwords do not match</p>
        </div>

        <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-400 hover:to-cyan-400 text-slate-950 font-bold rounded-xl shadow-lg shadow-teal-500/20 transition-all">
            Register Admin
        </button>
    </form>
</div>

<script>
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');
    const strengthIndicator = document.getElementById('strengthIndicator');
    const matchIndicator = document.getElementById('matchIndicator');

    password.addEventListener('input', () => {
        const val = password.value;
        if(val.length >= 8 && /[A-Z]/.test(val) && /[0-9]/.test(val)) {
            strengthIndicator.textContent = "Password Strength: Strong";
            strengthIndicator.className = "text-xs mt-1 text-teal-400 font-semibold";
        } else {
            strengthIndicator.textContent = "Password Strength: Weak (Min 8 chars, 1 uppercase, 1 number)";
            strengthIndicator.className = "text-xs mt-1 text-red-400 font-semibold";
        }
    });

    confirmPassword.addEventListener('input', () => {
        if(confirmPassword.value === password.value && confirmPassword.value !== '') {
            matchIndicator.textContent = "Passwords match!";
            matchIndicator.className = "text-xs mt-1 text-teal-400 font-semibold";
        } else {
            matchIndicator.textContent = "Passwords do not match";
            matchIndicator.className = "text-xs mt-1 text-red-400 font-semibold";
        }
    });
</script>
@endsection