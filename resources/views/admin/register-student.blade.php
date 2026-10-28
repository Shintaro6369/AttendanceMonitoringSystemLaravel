@extends('layouts.app')

@section('content')
<div class="glass-panel max-w-xl w-full p-8 rounded-3xl shadow-2xl border border-teal-500/30">
    <h2 class="text-2xl font-extrabold text-white mb-6">Register Student</h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-teal-500/20 border border-teal-500/30 text-teal-200 text-xs rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-500/20 border border-red-500/30 text-red-200 text-xs rounded-xl">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white focus:outline-none focus:border-teal-400">
        </div>

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Student Number</label>
            <input type="text" name="student_number" value="{{ old('student_number') }}" required class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white focus:outline-none focus:border-teal-400">
        </div>

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Course</label>
            <input type="text" name="course" value="{{ old('course') }}" placeholder="e.g. BSIT" required class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white focus:outline-none focus:border-teal-400">
        </div>

        <!-- NEW YEAR & SECTION FIELD -->
        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Year & Section</label>
            <input type="text" name="year_section" value="{{ old('year_section') }}" placeholder="e.g. 3-A" required class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white focus:outline-none focus:border-teal-400">
        </div>

        <div>
            <label class="block text-xs font-bold text-teal-300 uppercase tracking-wider mb-1">Profile Picture (Live Preview)</label>
            <input type="file" name="profile_picture" id="pictureInput" accept="image/*" class="w-full bg-slate-900/50 border border-teal-500/30 rounded-xl p-3 text-white text-xs file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-teal-500 file:text-slate-950 hover:file:bg-teal-400">
            
            <!-- Image Preview Box -->
            <div class="mt-3 flex items-center space-x-3">
                <img id="imagePreview" src="#" alt="Preview" class="w-16 h-16 rounded-full object-cover border-2 border-teal-400 hidden">
                <span id="previewText" class="text-xs text-slate-400">No image selected</span>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4">
            <a href="{{ route('admin.students.search') }}" class="text-xs text-teal-300 hover:underline">← Back to Search</a>
            <button type="submit" class="py-3 px-6 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-400 hover:to-cyan-400 text-slate-950 font-bold rounded-xl shadow-lg shadow-teal-500/20 transition-all">
                Register Student Account
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('pictureInput').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById('imagePreview');
            const previewText = document.getElementById('previewText');
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            previewText.classList.add('hidden');
        }
    });
</script>
@endsection