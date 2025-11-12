<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_positions', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('department');
            $table->string('location');
            $table->enum('employment_type', ['full-time', 'part-time', 'contract'])->default('full-time');
            $table->string('salary_range')->nullable();
            $table->date('application_deadline')->nullable();
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_positions');
    }
};
