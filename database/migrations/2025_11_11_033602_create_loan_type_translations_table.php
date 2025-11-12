<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_type_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_type_id')->constrained('loan_types')->onDelete('cascade');
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->text('conditions')->nullable();
            $table->text('collateral_info')->nullable();
            $table->timestamps();
            $table->unique(['loan_type_id', 'language_id'], 'loan_type_trans_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_type_translations');
    }
};
