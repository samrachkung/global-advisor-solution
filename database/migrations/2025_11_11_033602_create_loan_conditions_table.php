<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_type_id')->constrained('loan_types')->onDelete('cascade');
            $table->string('currency_type');
            $table->decimal('min_amount', 15, 2);
            $table->decimal('max_amount', 15, 2);
            $table->integer('max_duration_months');
            $table->integer('min_age');
            $table->integer('max_age');
            $table->decimal('max_debt_ratio', 5, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_conditions');
    }
};
