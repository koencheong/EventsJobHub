<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('employer_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'organization_type',
                'establishment_year',
                'about',
                'vision',
                'team_size',
            ]);
        });
    }

    public function down()
    {
        Schema::table('employer_profiles', function (Blueprint $table) {
            $table->string('organization_type')->nullable();
            $table->year('establishment_year')->nullable();
            $table->text('about')->nullable();
            $table->text('vision')->nullable();
            $table->integer('team_size')->nullable();
        });
    }
};
