<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('time_in');
            $table->timestamps(); // creates created_at and updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_logs');
    }
};