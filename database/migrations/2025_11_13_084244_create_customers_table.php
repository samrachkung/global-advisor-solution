<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            // same fields as contact_messages
            $table->string('customer_name');
            $table->string('email')->nullable();
            $table->string('phone_number', 30)->nullable();
            $table->decimal('loan_amount', 15, 2)->nullable();
            $table->foreignId('loan_type_id')->nullable()->constrained('loan_types')->nullOnDelete();
            $table->string('consultation', 100)->nullable();   // Phone | Office | Online
            $table->decimal('consultation_fee', 10, 2)->nullable();
            $table->date('consultation_date')->nullable();
            $table->time('consultation_time')->nullable();

            // workflow
            $table->enum('status', ['draft','complete'])->default('draft');
            $table->boolean('shared_to_telegram')->default(false);
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete(); // sales owner

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
