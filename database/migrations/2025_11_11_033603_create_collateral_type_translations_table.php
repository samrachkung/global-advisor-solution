<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collateral_type_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collateral_type_id')->constrained('collateral_types')->onDelete('cascade');
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->unique(['collateral_type_id', 'language_id'], 'collateral_trans_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collateral_type_translations');
    }
};
