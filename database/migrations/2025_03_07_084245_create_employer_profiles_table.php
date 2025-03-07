]
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('employer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->string('industry')->nullable();
            $table->string('organization_type')->nullable();
            $table->year('establishment_year')->nullable();
            $table->text('about')->nullable();
            $table->text('vision')->nullable();
            $table->string('company_location')->nullable();
            $table->integer('team_size')->nullable();
            $table->string('phone')->nullable();
            $table->string('business_email')->nullable();
            $table->string('company_website')->nullable();
            $table->json('social_media')->nullable();
            $table->string('company_logo')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employer_profiles');
    }
};
