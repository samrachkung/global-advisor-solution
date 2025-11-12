<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_position_id')->constrained('job_positions')->onDelete('cascade');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('resume');
            $table->text('cover_letter')->nullable();
            $table->enum('status', ['pending', 'reviewing', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
