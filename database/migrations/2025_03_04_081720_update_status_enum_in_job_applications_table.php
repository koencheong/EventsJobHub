<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE job_applications MODIFY COLUMN status ENUM('pending', 'approved', 'completed', 'rejected', 'paid', 'canceled') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        // If you ever need to rollback, restore the old enum values
        DB::statement("ALTER TABLE job_applications MODIFY COLUMN status ENUM('pending', 'approved', 'completed', 'rejected', 'paid', 'canceled') NOT NULL DEFAULT 'pending'");
    }
};

