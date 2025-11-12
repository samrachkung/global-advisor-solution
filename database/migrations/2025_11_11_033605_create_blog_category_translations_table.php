<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_category_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('blog_categories')->onDelete('cascade');
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->unique(['category_id', 'language_id'], 'blog_cat_trans_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_category_translations');
    }
};
