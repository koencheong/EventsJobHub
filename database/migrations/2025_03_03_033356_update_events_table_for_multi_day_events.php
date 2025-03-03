<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            // Rename the existing `date` column to `start_date`
            $table->renameColumn('date', 'start_date');
    
            // Add a new `end_date` column with a default value
            $table->date('end_date')->default('2023-01-01')->after('start_date');
        });
    }
    
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            // Revert the changes
            $table->renameColumn('start_date', 'date');
            $table->dropColumn('end_date');
        });
    }
};
