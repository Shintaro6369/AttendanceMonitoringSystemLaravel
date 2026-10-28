@extends('layouts.app')

@section('content')
<div class="glass-panel max-w-xl w-full p-8 rounded-3xl shadow-2xl border border-teal-500/30">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-extrabold text-white">Student Search Portal</h2>
        <div class="flex space-x-2">
            <a href="{{ route('admin.students.create') }}" class="text-xs bg-teal-500/20 hover:bg-teal-500/30 text-teal-300 border border-teal-500/30 px-3 py-2 rounded-xl transition font-semibold">Register New Student</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs bg-red-500/20 hover:bg-red-500/30 text-red-300 border border-red-500/30 px-3 py-2 rounded-xl transition font-semibold">Logout</button>
            </form>
        </div>
    </div>

    <!-- Search Form -->
    <form action="{{ route('admin.students.search') }}" method="GET" class="flex space-x-2 mb-6">
        <input type="text" name="student_number" value="{{ request('student_number') }}" placeholder="Enter Student Number..." required class="flex-1 bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white text-xs focus:outline-none focus:border-teal-400">
        <button type="submit" class="py-3 px-5 bg-gradient-to-r from-teal-500 to-cyan-500 text-slate-950 font-bold rounded-xl text-xs">Search</button>
    </form>

    @if(session('success'))
        <div class="mb-4 p-3 bg-teal-500/20 border border-teal-500/30 text-teal-200 text-xs rounded-xl">{{ session('success') }}</div>
    @endif

    <!-- Student Details Result Card -->
    @if(isset($student))
        @if($student)
            <div id="resultCard" class="p-6 bg-slate-900/60 rounded-2xl border border-teal-500/30 space-y-4 mb-4 relative">
                <div class="absolute top-4 right-4 text-xs font-mono text-teal-300 bg-teal-500/10 px-2 py-1 rounded-lg border border-teal-500/20">
                    Auto-clearing in <span id="countdown">5</span>s
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Direct image tag rendering the uploaded profile picture filename from database -->
                    <img src="{{ asset('storage/profile_pictures/' . $student->profile_picture) }}" 
                         class="w-16 h-16 rounded-full object-cover border-2 border-teal-400">
                    
                    <div class="space-y-1">
                        <h3 class="font-bold text-white text-lg">{{ $student->name }}</h3>
                        <p class="text-xs text-teal-300">Course: {{ $student->course }} | Section: {{ $student->year_section }}</p>
                        <p class="text-xs text-slate-400">Student No: {{ $student->student_number }}</p>
                        
                        <!-- Email & Unique Password Info -->
                        <p class="text-xs text-slate-300 pt-1">Email: <span class="font-mono text-teal-200">{{ $student->email }}</span></p>
                        <p class="text-xs text-slate-300">Password: <span class="font-mono text-teal-200">{{ $student->temp_password ?? 'Not Available' }}</span></p>

                        <!-- Latest Time-In Info -->
                        <p class="text-xs text-teal-400 font-semibold pt-1">
                            Latest Time-In: {{ isset($latestLog) && $latestLog ? $latestLog->created_at->format('Y-m-d h:i A') : 'No time-in logs yet' }}
                        </p>
                    </div>
                </div>

                <!-- Edit Student Account Button -->
                <a href="{{ route('admin.students.edit', $student->id) }}" class="block w-full py-2.5 text-center bg-teal-500/20 hover:bg-teal-500/30 text-teal-300 border border-teal-500/30 font-bold rounded-xl text-xs transition">
                    Edit Student Account
                </a>

                <!-- Delete Account Button (Only appears when student info is viewed) -->
                <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student account?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-2.5 bg-red-500/20 hover:bg-red-500/30 text-red-300 border border-red-500/30 font-bold rounded-xl text-xs transition">
                        Delete Student Account
                    </button>
                </form>
            </div>

            <script>
                // 5-second countdown & redirect back to default search state
                let timeLeft = 5;
                const timerElement = document.getElementById('countdown');
                const timer = setInterval(() => {
                    timeLeft--;
                    if(timerElement) timerElement.textContent = timeLeft;
                    if(timeLeft <= 0) {
                        clearInterval(timer);
                        window.location.href = "{{ route('admin.students.search') }}";
                    }
                }, 1000);
            </script>
        @else
            <div class="p-4 bg-red-500/20 border border-red-500/30 text-red-200 text-xs rounded-xl">
                No student found with that student number.
            </div>
        @endif
    @endif
</div>
@endsection