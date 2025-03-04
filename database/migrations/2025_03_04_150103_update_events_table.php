<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('is_approved'); // Remove is_approved column
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->boolean('is_approved')->default(0); // Re-add is_approved if rolling back
            $table->dropColumn('status'); // Remove status if rolling back
        });
    }
};

