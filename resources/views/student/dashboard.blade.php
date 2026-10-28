@extends('layouts.app')

@section('content')
<div class="glass-panel max-w-2xl w-full p-8 rounded-3xl shadow-2xl border border-teal-500/30">
    
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-white">Student Dashboard</h2>
            <p class="text-xs text-teal-200/80 mt-1">Welcome back, {{ Auth::user()->name }} ({{ Auth::user()->student_number }})</p>
        </div>
        
        <!-- Logout Button Only -->
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-xs bg-red-500/20 hover:bg-red-500/30 text-red-300 border border-red-500/30 px-3 py-2 rounded-xl transition font-semibold">
                Logout
            </button>
        </form>
    </div>

    <!-- Time-In Action Form -->
    <form action="{{ route('student.time-in') }}" method="POST" class="mb-8">
        @csrf
        <button type="submit" class="w-full py-4 px-4 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-400 hover:to-cyan-400 text-slate-950 font-bold rounded-2xl shadow-lg shadow-teal-500/20 transition-all transform hover:-translate-y-0.5 text-base tracking-wide">
            ⏱ Time-In Now
        </button>
    </form>

    <!-- Success Message Notification -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-teal-500/20 border border-teal-500/30 text-teal-200 text-xs rounded-xl">
            {{ session('success5') }}
            {{ session('success') }}
        </div>
    @endif

    <!-- Previous Logs Section -->
    <h3 class="font-bold text-lg text-white mb-4">Previous Time-In Logs</h3>
    
    <div class="overflow-x-auto rounded-2xl border border-teal-500/20 bg-slate-900/50">
        <table class="w-full text-left text-sm text-slate-200">
            <thead class="bg-teal-950/60 text-teal-300 uppercase text-xs tracking-wider border-b border-teal-500/20">
                <tr>
                    <th class="p-3.5">Date</th>
                    <th class="p-3.5">Time-In Timestamp</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-teal-500/10">
                @forelse($logs as $log)
                <tr class="hover:bg-teal-500/5 transition">
                    <td class="p-3.5 text-slate-300">{{ $log->created_at->format('Y-m-d') }}</td>
                    <td class="p-3.5 text-teal-300 font-mono">{{ $log->time_in }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="p-6 text-center text-slate-400 text-xs">No attendance logs found yet. Click time-in above!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection