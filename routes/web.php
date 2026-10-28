<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\PasswordResetController;

// 1. Hop-In Page (Welcome)
Route::view('/', 'welcome');

// 2. Admin Registration & Login Routes
Route::get('/register-admin', [AdminAuthController::class, 'showRegister'])->name('register.admin');
Route::post('/register-admin', [AdminAuthController::class, 'register'])->name('register.submit');

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// 3. Global Logout Route (MUST be here so `route('logout')` works everywhere)
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// 4. Admin Dashboard Routes (Protected by Admin Role Check)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/register-student', function () {
        if (Auth::user()->role !== 'admin') { abort(403); }
        return app(StudentController::class)->create();
    })->name('students.create');

    Route::post('/register-student', function () {
        if (Auth::user()->role !== 'admin') { abort(403); }
        return app(StudentController::class)->store(request());
    })->name('students.store');

    Route::get('/search-student', function () {
        if (Auth::user()->role !== 'admin') { abort(403); }
        return app(StudentController::class)->search(request());
    })->name('students.search');

    Route::delete('/student/{id}', function ($id) {
        if (Auth::user()->role !== 'admin') { abort(403); }
        return app(StudentController::class)->destroy($id);
    })->name('students.destroy');

    // Admin-Only Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// 5. Student Dashboard Routes (Protected by Student Role Check - No Profile Access)
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::user()->role !== 'student') { abort(403); }
        return app(StudentController::class)->studentDashboard();
    })->name('dashboard');

    Route::post('/time-in', function () {
        if (Auth::user()->role !== 'student') { abort(403); }
        return app(StudentController::class)->timeIn(request());
    })->name('time-in');
});

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// 2FA Verification Routes
Route::get('/2fa-verify', [TwoFactorController::class, 'showVerify'])->name('2fa.verify');
Route::post('/2fa-verify', [TwoFactorController::class, 'verify'])->name('2fa.verify.submit');

// Admin Profile Edit Routes
Route::get('/admin/profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
Route::put('/admin/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');

// Student Edit Routes (from Search Portal)
Route::get('/admin/students/{id}/edit', [StudentController::class, 'edit'])->name('admin.students.edit');
Route::put('/admin/students/{id}', [StudentController::class, 'update'])->name('admin.students.update');

Route::get('/forgot-password', [PasswordResetController::class, 'showEmailForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'verifyEmail'])->name('password.email');
Route::get('/reset-password', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [PasswordResetController::class, 'updatePassword'])->name('password.update');