<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade'); // Event being rated
            $table->foreignId('from_user_id')->constrained('users')->onDelete('cascade'); // Who is giving the rating
            $table->foreignId('to_user_id')->constrained('users')->onDelete('cascade'); // Who is receiving the rating
            $table->tinyInteger('rating')->unsigned(); // Rating (1-5 stars)
            $table->text('feedback')->nullable(); // Optional feedback
            $table->enum('type', ['part_timer_to_employer', 'employer_to_part_timer']); // Rating type
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ratings');
    }
};
