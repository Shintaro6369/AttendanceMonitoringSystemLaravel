<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('student'); // 'admin' or 'student'
            $table->string('student_number')->nullable()->unique();
            $table->string('course')->nullable();
            $table->string('profile_picture')->default('default-emo.jpg');
            $table->boolean('google2fa_enabled')->default(false);
            $table->text('google2fa_secret')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'student_number',
                'course',
                'profile_picture',
                'google2fa_enabled',
                'google2fa_secret'
            ]);
        });
    }
};