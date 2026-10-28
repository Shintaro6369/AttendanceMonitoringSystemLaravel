@extends('layouts.app')

@section('content')
<div class="glass-panel max-w-md w-full p-8 rounded-3xl shadow-2xl text-center border border-teal-500/30">
    
    <!-- Icon header -->
    <div class="mx-auto w-14 h-14 bg-gradient-to-tr from-teal-500 to-cyan-400 rounded-2xl flex items-center justify-center shadow-lg shadow-teal-500/30 mb-6">
        <svg class="w-7 h-7 text-slate-950" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </div>

    <h2 class="text-2xl font-extrabold text-white mb-2">Welcome to Attendance Monitoring</h2>
    <p class="text-xs text-teal-200/80 mb-8 leading-relaxed">Streamline and track student attendance seamlessly across all courses.</p>
    
    <!-- Action Buttons -->
    <div class="space-y-4">
        <a href="{{ route('login') }}" class="block w-full py-3.5 px-4 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-400 hover:to-cyan-400 text-slate-950 font-bold rounded-xl shadow-lg shadow-teal-500/20 transition-all transform hover:-translate-y-0.5">
            Login
        </a>
        <a href="{{ route('register.admin') }}" class="block w-full py-3.5 px-4 bg-slate-900/60 hover:bg-slate-900 text-teal-300 border border-teal-500/30 font-semibold rounded-xl transition-all">
            Register as Admin
        </a>
    </div>
</div>
@endsection