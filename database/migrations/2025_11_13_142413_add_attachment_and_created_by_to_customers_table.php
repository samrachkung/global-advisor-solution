<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            if (!Schema::hasColumn('customers', 'attachment')) {
                $table->string('attachment')->nullable()->after('consultation_time'); // path in storage
            }
            if (!Schema::hasColumn('customers', 'created_by')) {
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->after('owner_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            if (Schema::hasColumn('customers', 'created_by'))
                $table->dropConstrainedForeignId('created_by');
            if (Schema::hasColumn('customers', 'attachment'))
                $table->dropColumn('attachment');
        });
    }

};
