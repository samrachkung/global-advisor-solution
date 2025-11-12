<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slideshow_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slideshow_id')->constrained('slideshows')->onDelete('cascade');
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('button_text')->nullable();
            $table->timestamps();
            $table->unique(['slideshow_id', 'language_id'], 'slideshow_trans_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slideshow_translations');
    }
};
