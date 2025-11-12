<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_position_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_position_id')->constrained('job_positions')->onDelete('cascade');
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->text('requirements');
            $table->text('responsibilities');
            $table->text('benefits')->nullable();
            $table->timestamps();
            $table->unique(['job_position_id', 'language_id'], 'job_pos_trans_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_position_translations');
    }
};
