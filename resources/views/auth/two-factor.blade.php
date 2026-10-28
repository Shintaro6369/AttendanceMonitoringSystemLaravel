@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow mt-10">
    <h2 class="text-xl font-bold mb-4">Two-Factor Authentication</h2>
    <p class="text-sm text-gray-600 mb-4">Please enter the 6-digit code from your Google Authenticator app.</p>

    <form method="POST" action="{{ route('2fa.verify') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium">Authentication Code</label>
            <input type="text" name="one_time_password" required autofocus class="w-full border p-2 rounded mt-1 text-center tracking-widest text-lg" maxlength="6">
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Verify Code</button>
    </form>
</div>
@endsection